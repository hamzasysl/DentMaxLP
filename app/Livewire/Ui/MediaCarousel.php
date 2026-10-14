<?php

namespace App\Livewire\Ui;

use Livewire\Component;

class MediaCarousel extends Component
{
    public array $items = [];

    public function mount(array $items = []): void
    {
        $this->items = $items;
    }

    public function render()
    {
        return view('livewire.Ui.media-carousel');
    }
}
