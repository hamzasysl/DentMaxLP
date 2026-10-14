<?php

namespace App\Livewire\Ui\Modals;

use Livewire\Component;
use Livewire\Attributes\On;

class LuckySpinModal extends Component
{
    public bool $open = false;

    // opsiyonel: modal başlığı/variant vb
    public ?string $title = null;

    public function mount(bool $open = false, ?string $title = null): void
    {
        $this->open = $open;
        $this->title = $title;
    }

    #[On('lucky-spin-modal:open')]
    public function openModal(): void
    {
        $this->open = true;
    }

    #[On('lucky-spin-modal:close')]
    public function closeModal(): void
    {
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.Ui.modals.lucky-spin-modal');
    }
}
