<?php

namespace App\Livewire;

use App\Http\Services\NavigationService;
use Livewire\Component;

class Calendar extends Component
{
    public function render()
    {
        $nav = new NavigationService();
        $nav->setCalendarUrl();

        return view('livewire.calendar')->with([
            'team' => $nav->getUser()->currentTeam,
        ]);
    }
}
