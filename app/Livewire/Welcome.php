<?php

namespace App\Livewire;

use App\Http\Services\NavigationService;
use Livewire\Component;

class Welcome extends Component
{
    public $calendarUrl;

    public function render()
    {
        $nav = new NavigationService();
        $nav->setCalendarUrl();
        $this->calendarUrl = $nav->getCalendarUrl();

        return view('livewire.welcome');
    }
}
