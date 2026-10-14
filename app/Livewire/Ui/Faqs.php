<?php

namespace App\Livewire\Ui;
use Livewire\Component;
use App\Traits\HasAccordion;

class Faqs extends Component
{
    use HasAccordion;

    public array $items = [];

    public function mount(array $items = [], int $openIndex = 0): void
    {
        $this->items = $items;
        $this->setOpenIndex($openIndex);
    }

    public function render()
    {
        return view('livewire.Ui.faqs');
    }
}
