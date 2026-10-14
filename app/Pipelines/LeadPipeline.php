<?php

namespace App\Pipelines;

use App\Mail\LeadSubmitted;
use App\Models\FormSubmission;
use App\Services\ClientIp;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Torann\GeoIP\Facades\GeoIP;

class LeadPipeline
{
    private const CORE_FIELDS = [
        'name',
        'phone',
        'email',
        'message',
    ];

    public static function handle(string $formType, array $payload): FormSubmission
    {
        $ip  = ClientIp::get();
        $loc = self::resolveGeo($ip);

        // 1) details varsa düzleştir
        $payload = self::flattenIncomingDetails($payload);

        // 2) core alanları ayır
        $core = [];
        foreach (self::CORE_FIELDS as $field) {
            if (array_key_exists($field, $payload)) {
                $core[$field] = $payload[$field];
                unset($payload[$field]);
            }
        }

        // 3) kalan her şey details
        $details = $payload;

        // 4) DB kayıt
        $submission = FormSubmission::create([
            'form_type'   => $formType,
            'source'      => session('lp_name', session('lp_title', 'unknown')),
            'locale'      => app()->getLocale(),

            'geo_country' => $loc['country'],
            'geo_region'  => $loc['region'],
            'geo_city'    => $loc['city'],

            'ip'          => $ip,
            'user_agent'  => request()->userAgent(),

            ...$core,
            'details'     => $details,
        ]);

        // 5) Mail
        self::sendMail($submission->id);

        // 6) Remote CRM push — landing_id tanımlıysa, kullanıcıyı bekletmeden terminating'de.
        self::pushToCrm($core, $details);

        return $submission;
    }

    private static function pushToCrm(array $core, array $details): void
    {
        $landingId = config('lead.crm.landing_id');
        $url       = config('lead.crm.url');

        if (!$landingId || !$url) {
            return;
        }

        $crmPayload = [
            'landing_id' => (int) $landingId,
            'name'       => $core['name']  ?? null,
            'phone'      => $core['phone'] ?? null,
            'email'      => $core['email'] ?? null,

            'other_details' => collect($details)
                ->except(['message', 'mesaj'])
                ->merge(['Mesaj' => $core['message'] ?? null])
                ->filter(fn ($v) => $v !== null && $v !== '')
                ->mapWithKeys(fn ($v, $k) => [
                    ucwords(str_replace('_', ' ', (string) $k)) =>
                        (is_string($v)
                            ? ucwords(str_replace(['_', '-'], ' ', $v))
                            : $v)
                ])
                ->toArray(),
        ];

        app()->terminating(function () use ($crmPayload, $url) {
            try {
                Http::acceptJson()
                    ->asJson()
                    ->connectTimeout(3)
                    ->timeout(6)
                    ->post($url, $crmPayload);
            } catch (\Throwable $e) {
                report($e);
            }
        });
    }

    private static function flattenIncomingDetails(array $payload): array
    {
        if (isset($payload['details']) && is_array($payload['details'])) {
            $payload = array_merge($payload['details'], $payload);
        }

        unset($payload['details']);

        return $payload;
    }

    private static function resolveGeo(string $ip): array
    {
        try {
            $loc = GeoIP::getLocation($ip)?->toArray() ?? [];
        } catch (\Throwable) {
            return ['country' => null, 'region' => null, 'city' => null];
        }

        return [
            'country' => $loc['country_code2'] ?? null,
            'region'  => $loc['state_prov'] ?? null,
            'city'    => $loc['city'] ?? null,
        ];
    }

    private static function sendMail(int $submissionId): void
    {
        $to  = config('lead.mail.to', []);
        $cc  = config('lead.mail.cc', []);
        $bcc = config('lead.mail.bcc', []);

        // Alıcı yoksa CC'deki ilk adresi ana alıcı yap
        if ($to === [] && $cc !== []) {
            $to = [array_shift($cc)];
        }

        if ($to === []) {
            return;
        }

        app()->terminating(function () use ($submissionId, $to, $cc, $bcc) {
            try {
                app()->instance('lead_submission_id', $submissionId);

                Mail::to($to)
                    ->cc($cc)
                    ->bcc($bcc)
                    ->send(new LeadSubmitted());
            } catch (\Throwable $e) {
                report($e);
            }
        });
    }
}
