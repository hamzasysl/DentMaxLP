<?php

namespace App\Livewire\Invisalign;

use App\Livewire\Foundation\LocaleComponent;

abstract class Base extends LocaleComponent
{
    // Diller config('brand.locales')'tan gelir; bu LP'ye özel kısıt gerekirse burada override et.

    protected function lpPayload(array $extra = []): array
    {
        $loc = app()->getLocale();

        $title = match ($loc) {
            'tr' => 'Invisalign Şeffaf Plak Tedavisi İstanbul | Kahraman Ortodonti',
            default => 'Invisalign Clear Aligners in Turkey',
        };

        // lp_title WhatsApp karşılama mesajında konu olarak geçer ("… için danışmanlık almak istiyorum")
        session([
            'lp_title' => 'Invisalign şeffaf plak tedavisi',
            'lp_name'  => 'Invisalign',
        ]);

        $base = [
            ...$this->brandPayload(),

            'lpName' => 'Invisalign',
            'title'  => $title,

            // ✅ SEO default (sayfa override edebilir)
            'seo' => [
                'title' => $title,
                'description' => match ($loc) {
                    'tr' => 'Ortodonti uzmanı Yrd. Doç. Dr. Fatih Kahraman ile Invisalign şeffaf plak tedavisi. 3D planlama, tel yok. İstanbul Bakırköy’de ücretsiz muayene.',
                    default => 'Invisalign clear aligner treatment: straighten your teeth with nearly invisible aligners and a personalised plan.',
                },
                'og_image' => asset('img/lp/invisalign/og.jpg') . '?v=' . @filemtime(public_path('img/lp/invisalign/og.jpg')),
                'canonical' => url()->current(),
                'robots' => 'index,follow',
            ],
        ];

        // extra ile gelenleri üstüne yaz (özellikle seo override için)
        return array_replace_recursive($base, $extra);
    }
}
