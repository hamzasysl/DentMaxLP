<?php

namespace App\Livewire\Ui;

use Livewire\Component;
use App\Traits\HasBeforeAfterCases;

class BeforeAfterSlider extends Component
{
    use HasBeforeAfterCases;

    public function mount(array $cases = []): void
    {
        $this->setCases($cases);
    }

    public function render()
    {
        return view('livewire.Ui.before-after-slider');
    }
}
