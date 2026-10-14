<?php

namespace App\Livewire\Ui\Modals;

use Livewire\Component;

class BookConsultationModal extends Component
{
    public bool $open = false;
    public string $topic = '';

    protected $listeners = [
        'open-book-consultation' => 'openModal',
        'close-book-consultation' => 'closeModal',
    ];

    public function openModal(?string $topic = null): void
    {
        $this->topic = (string) $topic;
        $this->open = true;
    }

    public function closeModal(): void
    {
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.Ui.modals.book-consultation-modal');
    }
}
