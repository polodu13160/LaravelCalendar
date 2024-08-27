<?php

namespace App\Livewire;

class Calendar extends AbstractComponent
{
    public $selectedUsers;

    public function mount()
    {
        parent::mount();
        $this->selectedUsers = [];
    }

    public function render()
    {
        return view('livewire.calendar')->with([
            'team' => $this->team,
        ]);
    }
}
