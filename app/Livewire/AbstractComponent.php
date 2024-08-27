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

    public function isLoggedUserAdmin()
    {
        return $this->user->isAdmin();
    }

    public function redirectToDashboard()
    {
        return redirect()->route('dashboard');
    }

    public function redirectToDashboardIfNotAdmin()
    {
        if (! $this->isLoggedUserAdmin()) {
            $this->redirectToDashboard();
        }
    }

    public function render()
    {
        return view('livewire.abstract-component');
    }
}
