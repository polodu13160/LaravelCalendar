<?php

namespace App\Livewire;

use App\Livewire\Forms\EventForm;
use App\Models\Events;
use LivewireUI\Modal\ModalComponent;

class EventModal extends ModalComponent
{
    public ?Events $events = null;

    public string $timezone;

    public $visibilityOptions;

    public $categoryOptions;

    public EventForm $form;

    public function mount(?Events $events, $timezone)
    {
        $this->visibilityOptions = include base_path('app/Tableaux/Visibility.php');
        $this->categoryOptions = include base_path('app/Tableaux/Categories.php');
        if ($events && $events->exists) {
            $this->form->setEvent($events, $timezone);
        }
    }

    public function save()
    {
        $this->form->store($this->timezone);
        $this->closeModal();
    }

    public function update()
    {
        $this->form->update();
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.event-modal');
    }
}
