<?php

namespace App\Livewire\Stories;

use App\Livewire\Invisalign\Base;

/** /hasta-hikayeleri — tüm hasta hikayeleri (config/stories.php) */
class Index extends Base
{
    public function render()
    {
        $stories = config('stories.items', []);

        $payload = $this->lpPayload([
            'seo' => [
                'title'       => 'Hasta Hikayeleri – Invisalign Tedavi Süreçleri',
                'description' => 'Yrd. Doç. Dr. Fatih Kahraman ile Invisalign tedavisi gören hastaların başlangıçtan sonuca kadar tedavi süreçleri.',
                'canonical'   => route('stories.index'),
                'robots'      => config('stories.publish') ? 'index,follow' : 'noindex,nofollow',
            ],
        ]);

        return view('livewire.stories.index', $payload + ['stories' => $stories])
            ->layout('layouts.app', $payload);
    }
}
