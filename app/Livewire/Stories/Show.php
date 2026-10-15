<?php

namespace App\Livewire\Stories;

use App\Livewire\Invisalign\Base;

/** /hasta-hikayeleri/{slug} — tek hastanın tedavi süreci */
class Show extends Base
{
    public string $slug = '';

    public function mount(string $slug = ''): void
    {
        parent::mount();

        abort_unless(collect(config('stories.items', []))->contains('slug', $slug), 404);
        $this->slug = $slug;
    }

    public function render()
    {
        $items = array_values(config('stories.items', []));
        $index = collect($items)->search(fn ($s) => $s['slug'] === $this->slug);
        $story = $items[$index];
        $next  = count($items) > 1 ? $items[($index + 1) % count($items)] : null;

        $payload = $this->lpPayload([
            'seo' => [
                'title'       => "{$story['name']} – {$story['condition_label']} Invisalign Tedavisi",
                'description' => \Illuminate\Support\Str::limit($story['summary'], 155),
                'canonical'   => route('stories.show', $story['slug']),
                'robots'      => (config('stories.publish') && empty($story['example'])) ? 'index,follow' : 'noindex,nofollow',
                'og_image'    => $story['photos']['after'] ? asset($story['photos']['after']) : asset('img/lp/invisalign/og.jpg'),
            ],
        ]);

        return view('livewire.stories.show', $payload + ['story' => $story, 'next' => $next])
            ->layout('layouts.app', $payload);
    }
}
