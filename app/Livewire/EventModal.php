<?php

namespace App\Livewire;

use App\Livewire\Forms\EventForm;
use App\Models\Events;
use LivewireUI\Modal\ModalComponent;

class EventModal extends ModalComponent
{
    public ?Events $events = null;

    public EventForm $form;

    public function mount(?Events $events = null)
    {
        if ($events && $events->exists) {
            $this->form->setEvent($events);
        }
    }

    public function save()
    {
        $this->form->store();
        $this->closeModal();
    }

    public function update()
    {
        $this->form->update();
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.event-form');
    }
}
