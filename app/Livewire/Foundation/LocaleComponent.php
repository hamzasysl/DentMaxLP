<?php

namespace App\Livewire\Foundation;

use Livewire\Component;

abstract class LocaleComponent extends Component
{
    public array $locales = []; // boşsa config('brand.locales'), child override edebilir

    public function mount(): void
    {
        if ($this->locales === []) {
            $this->locales = config('brand.locales');
        }

        $lang = request()->segment(1);

        // Livewire internal endpoint'lerinde locale kontrolü yapma
        if ($lang === 'livewire') {
            return;
        }

        if (!in_array($lang, $this->locales, true)) {
            abort(404);
        }

        app()->setLocale($lang);
    }

    public function switchLocale(string $locale)
    {
        if (!in_array($locale, config('brand.locales'), true)) {
            return null;
        }

        cookie()->queue(cookie('locale', $locale, 60 * 24 * 365));

        // Livewire POST /livewire/update yerine gerçek sayfayı baz al
        $ref  = request()->headers->get('referer') ?? url()->previous();
        $path = $ref ? parse_url($ref, PHP_URL_PATH) : '/';

        $segments = array_values(array_filter(explode('/', trim((string) $path, '/'))));

        // /en/... yoksa direkt /{locale} yönlendir
        if (!isset($segments[0])) {
            return redirect('/' . $locale);
        }

        $segments[0] = $locale;

        return redirect('/' . implode('/', $segments));
    }

    /**
     * Tüm LP'lerde ortak marka/iletişim verisi (config/brand.php)
     */
    protected function brandPayload(): array
    {
        $contact = config('brand.contact');
        $social  = config('brand.social');

        return [
            'locales'      => $this->locales ?: config('brand.locales'),
            'activeLocale' => app()->getLocale(),

            'brandName'    => config('brand.name'),

            'phoneText'    => $contact['phone_text'],
            'phoneLink'    => '+' . preg_replace('/\D+/', '', $contact['phone_link']),
            'whatsappText' => $contact['whatsapp_text'],
            'whatsappLink' => preg_replace('/\D+/', '', $contact['whatsapp_link']), // wa.me sadece rakam kabul eder
            'whatsappUrl'  => \App\Support\WhatsApp::url(), // hazır mesajlı wa.me linki
            'email'        => $contact['email'],
            'address'      => $contact['address'],
            'mapsLink'     => $contact['maps_link'] ?? null,

            'instagramLink' => $social['instagram'],
            'facebookLink'  => $social['facebook'],
            'youtubeLink'   => $social['youtube'],
        ];
    }

    public function payload(array $extra = []): array
    {
        return $this->lpPayload($extra);
    }

    abstract protected function lpPayload(array $extra = []): array;
}
