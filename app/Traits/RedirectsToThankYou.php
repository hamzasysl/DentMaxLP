<?php

namespace App\Traits;

trait RedirectsToThankYou
{
    protected function redirectToThankYou(array $data = []): mixed
    {
        session()->put('thank_you_allowed', true);
        session()->put('thank_you_data', $data);

        $target = url($this->thankYouUrlFromReferer());

        // ✅ Yeni sekmede aç
        //  $this->js("window.open(" . json_encode($target) . ", '_blank', 'noopener,noreferrer');");
        return redirect()->to($target);

        // Aynı sayfada kal
        return null;
    }



    // Submit response'una eklenip Livewire redirect'inden ÖNCE çalışır:
    // yeni sekmede WhatsApp konuşması açar. Boş mesajla düz konuşma başlatır.
    protected function openWhatsAppTab(?string $message = null): void
    {
        if (!config('lead.open_whatsapp_after_submit')) {
            return;
        }

        $phone = preg_replace('/\D+/', '', config('brand.contact.whatsapp_link'));
        $url = 'https://wa.me/' . $phone;
        $msg = is_string($message) ? trim($message) : '';
        if ($msg !== '') {
            $url .= '?text=' . rawurlencode($msg);
        }
        $this->js("window.open(" . json_encode($url) . ", '_blank', 'noopener');");
    }

    // Formdan gelen bilgilere göre zengin WhatsApp mesajı derler.
    // $type: 'simple' | 'step' | 'spin'
    // $data: form alanları (name, phone, email, message, gender, toothModel, prize)
    protected function buildLeadWhatsAppMessage(string $type, array $data): string
    {
        $topic = trim((string) session('lp_title', session('lp_name', 'danışmanlık')));

        $greeting = match ($type) {
            'step' => __('front.global.wa-lead.greeting-step', ['topic' => $topic]),
            'spin' => __('front.global.wa-lead.greeting-spin', [
                'prize' => trim((string) ($data['prize'] ?? '')),
            ]),
            default => __('front.global.wa-lead.greeting-simple', ['topic' => $topic]),
        };

        $lines = [$greeting, ''];

        // İletişim bilgileri
        $details = [];
        if (!empty($data['name']))  $details[] = __('front.global.wa-lead.field-name')  . ': ' . $data['name'];
        if (!empty($data['phone'])) $details[] = __('front.global.wa-lead.field-phone') . ': ' . $data['phone'];
        if (!empty($data['email'])) $details[] = __('front.global.wa-lead.field-email') . ': ' . $data['email'];

        if ($details) {
            $lines[] = '— ' . __('front.global.wa-lead.section-details') . ' —';
            $lines = array_merge($lines, $details);
            $lines[] = '';
        }

        // Analiz seçimleri (step form)
        $analysis = [];
        if (!empty($data['gender'])) {
            $genderLabel = $data['gender'] === 'women'
                ? __('front.global.wa-lead.gender-women')
                : __('front.global.wa-lead.gender-men');
            $analysis[] = __('front.global.wa-lead.field-gender') . ': ' . $genderLabel;
        }
        if (!empty($data['toothModel'])) {
            $analysis[] = __('front.global.wa-lead.field-tooth') . ': ' . ucwords(str_replace(['-', '_'], ' ', $data['toothModel']));
        }
        if (!empty($data['prize'])) {
            $analysis[] = __('front.global.wa-lead.field-prize') . ': ' . $data['prize'];
        }

        if ($analysis) {
            $lines[] = '— ' . __('front.global.wa-lead.section-analysis') . ' —';
            $lines = array_merge($lines, $analysis);
            $lines[] = '';
        }

        // Kullanıcı mesajı
        if (!empty($data['message'])) {
            $lines[] = '— ' . __('front.global.wa-lead.section-message') . ' —';
            $lines[] = trim((string) $data['message']);
        }

        return trim(implode("\n", $lines));
    }

    protected function thankYouUrlFromReferer(): string
    {
        return route('thank-you', absolute: false);
    }
}
