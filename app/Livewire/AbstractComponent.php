<?php

namespace App\Livewire;

use Livewire\Component;

class AbstractComponent extends Component
{
    protected $user;

    protected $team;

    protected $calendarUrl;

    public function mount()
    {
        $this->user = auth()->user();
        $this->team = $this->user->currentTeam;
        $this->calendarUrl = $this->user->getCalendarUrl();
    }

    protected function getUser()
    {
        return $this->user;
    }

    protected function setUser($user)
    {
        $this->user = $user;
    }

    protected function getTeam()
    {
        return $this->team;
    }

    protected function setTeam($team)
    {
        $this->team = $team;
    }

    protected function getCalendarUrl()
    {
        return $this->calendarUrl;
    }

    protected function setCalendarUrl($calendarUrl)
    {
        $this->calendarUrl = $calendarUrl;
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
