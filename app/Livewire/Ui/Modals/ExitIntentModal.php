<?php

namespace App\Livewire\Ui\Modals;

use Livewire\Component;

class ExitIntentModal extends Component
{
    public bool $open = false;

    protected $listeners = [
        'open-exit-intent'  => 'openModal',
        'close-exit-intent' => 'closeModal',
    ];

    public function openModal(): void
    {
        $this->open = true;
        $this->dispatch('modal-opened');
    }

    public function closeModal(): void
    {
        $this->open = false;
        $this->dispatch('exit-intent:dismiss'); // aynı sayfada tekrar açmasın
        $this->dispatch('modal-closed');
    }

    public function render()
    {
        return view('livewire.Ui.modals.exit-intent-modal');
    }
}
