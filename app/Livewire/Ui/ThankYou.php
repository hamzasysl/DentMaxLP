<?php

namespace App\Livewire\Ui;

use Illuminate\Support\Str;
use Livewire\Component;

class ThankYou extends Component
{
    public array $thankYouData = [];

    public function mount(): void
    {
        app()->setLocale(config('brand.default_locale', 'tr'));

        // ✅ GEÇİCİ: tamamen açık olsun (formdan gelme şartını kapattık)
         abort_unless(session()->get('thank_you_allowed'), 404);
         session()->forget('thank_you_allowed');

        // Formdan gelen veriler (yoksa boş)
        $this->thankYouData = session()->pull('thank_you_data', []);
    }

    public function render()
    {
        // Route parametresi gelmediyse mount'tan geleni kullan (veya fallback)
        $lp = config('brand.default_lp');

        $ns = Str::studly(str_replace('-', ' ', $lp));
        $indexClass = "App\\Livewire\\{$ns}\\Index";

        // ✅ GEÇİCİ: class yoksa 404 atma, basit payload ile devam et
        if (! class_exists($indexClass)) {
            $payload = [
                'seo' => [
                    'title' => 'Thank You',
                    'description' => '',
                    'og_image' => null,
                    'canonical' => url()->current(),
                    'robots' => 'noindex,nofollow',
                ],
            ];

            return view('livewire.Ui.thank-you', $payload + [
                    'thankYouData' => $this->thankYouData,
                    'lpSlug'       => $lp,
                ])->layout('layouts.app', $payload);
        }

        /** @var object $index */
        $index = app($indexClass);

        $payload = $index->payload([
            'seo' => [
                'robots'    => 'noindex,nofollow',
                'canonical' => url()->current(),
            ],
        ]);

        return view('livewire.Ui.thank-you', $payload + [
                'thankYouData' => $this->thankYouData,
                'lpSlug'       => $lp,
            ])->layout('layouts.app', $payload);
    }
}
