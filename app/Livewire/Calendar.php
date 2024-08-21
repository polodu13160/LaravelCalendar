<?php

namespace App\Livewire;

use Livewire\Component;

class Calendar extends Component
{
    public $user;

    public $team;

    public $teamMembers;

    public $selectedUsers;

    public $allUrlIcsEvents = [];

    public $calendarUrls = [];

    public function mount()
    {
        $this->user = auth()->user();
        $this->team = $this->user->currentTeam;
        $this->selectedUsers = [];
    }

    public function render()
    {
        return view('livewire.calendar')->with([
            'team' => $this->team,
        ]);
    }
}
