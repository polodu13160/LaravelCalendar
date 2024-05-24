<?php

namespace App\Livewire;

use App\CategoriesIcal;
use App\Livewire\Forms\EventForm;
use App\Models\Events;
use LivewireUI\Modal\ModalComponent;

class EventModal extends ModalComponent
{
    // public ?Events $events = null;
    public EventForm $form;
    public $date;
    public $dateTest;
    public  $allCategoriesIcal;


    public function mount()
    {
        $date = new \DateTime($this->date);
        $this->form->start = $date->format('Y-m-d H:i:s');
        $date->modify('+1 hour');
        $this->form->end = $date->format('Y-m-d H:i:s');
        $this->allCategoriesIcal = [
            'appel',
            'évenement',
            'réunion',
            'rdv',
            'congé',
            'formation',
            'autre',
        ];

    }

    

    public function save()
    {
        $validatedData = $this->validate([
            'form.title' => 'required|max:255',
            'form.description' => 'nullable',
            'form.is_all_day' => 'boolean',
            'form.visibility' => 'boolean',
            'form.start' => 'required|date',
            'form.end' => 'required|date|after_or_equal:form.start',
            'form.categorieIcal' => 'required|in:appel,évenement,réunion,rdv,congé,formation,autre',
        ]);
        
        
        $this->form->store();
        $this->closeModal();
        return $this->redirect('/calendar');
    }

    // public function update()
    // {
    //     $this->form->update();
    //     $this->closeModal();
    //     return $this->redirect('/calendar');
    // }

    public function render()
    {
        return view('livewire.event-modal');
    }
}
