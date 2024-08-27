<?php

namespace App\Livewire;

class Calendar extends AbstractComponent
{
    public $teamMembers;

    public $selectedUsers;

    public $allUrlIcsEvents = [];

    public $calendarUrls = [];

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
