<?php

namespace App\Livewire;

use Livewire\Component;

class AbstractComponent extends Component
{
    public $user;

    public $team;

    public $calendarUrl;

    public function mount()
    {
        $this->user = auth()->user();
        $this->team = $this->user->currentTeam;
        $this->calendarUrl = $this->user->getCalendarUrl();
    }

    protected function isLoggedUserAdmin()
    {
        return $this->user->isAdmin();
    }

    protected function redirectToDashboardIfNotAdmin()
    {
        if (! $this->isLoggedUserAdmin()) {
            redirect()->route('dashboard');
        }
    }

    public function render()
    {
        return view('livewire.abstract-component');
    }
}
