<?php

namespace App\Livewire\Ui;

use Livewire\Component;

class OurDoctors extends Component
{
    /** HollywoodSmile\Index içinden gelecek */
    public array $items = [];

    /** Modal için seçili doktor */
    public ?array $activeDoctor = null;

    public function mount(array $items = []): void
    {
        $this->items = $items;
    }

    /** 3’ten fazlaysa kaydır */
    public function getShouldSlideProperty(): bool
    {
        return count($this->items) > 3;
    }

    public function openDoctor(int $id): void
    {
        $doc = collect($this->items)->firstWhere('id', $id);
        if (!$doc) return;

        $this->activeDoctor = $doc;
        $this->dispatch('open-doctor-modal');
    }

    public function closeDoctor(): void
    {
        $this->activeDoctor = null;
        $this->dispatch('close-doctor-modal');
    }

    public function render()
    {
        return view('livewire.Ui.our-doctors');
    }
}
