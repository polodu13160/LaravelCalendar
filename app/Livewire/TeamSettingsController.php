<?php

namespace App\Livewire;

class TeamSettingsController extends AbstractComponent
{
    public function render()
    {
        return view('livewire.team-settings-controller')->with([
            'team' => $this->team,
            'isAdmin' => $this->isLoggedUserAdmin(),
            'isModerator' => $this->isLoggedUserModerator(),
        ]);
    }
}
