<?php

namespace App\Livewire;

use App\Http\Services\NavigationService;
use Livewire\Component;

class TeamSettingsController extends Component
{
    public $isAdmin;

    public $isModerator;

    public function render()
    {
        $nav = new NavigationService;
        $this->isAdmin = $nav->getIsUserAdmin();
        $this->isModerator = $nav->getIsUserModerator();

        return view('livewire.team-settings-controller')->with([
            'team' => $nav->getUser()->currentTeam,
            'isAdmin' => $this->isAdmin,
            'isModerator' => $this->isModerator,
        ]);
    }
}
