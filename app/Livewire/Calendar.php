<?php

namespace App\Livewire;

use App\Http\Services\NavigationService;
use App\Models\Calendarobject;
use App\Models\Events;
use Livewire\Component;

class Calendar extends Component
{
    public $events = [];

    public $allUrlIcsEvents = [];

    public $calendarUrl;

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        $this->events = json_encode(Events::all());

        $nav = new NavigationService();
        $nav->setCalendarUrl();
        $this->calendarUrl = $nav->getCalendarUrl();

        $calendarobjectsUser = Calendarobject::where('calendarid', $nav->getCalendar()->calendarid)->get();

        foreach ($calendarobjectsUser as $calendarobject) {

            $ics = $calendarobject->uri; //cest les données brut d'un fichier ics la
            $this->allUrlIcsEvents[] = "$this->calendarUrl/$ics";
        }

        return view('livewire.calendar')->with([
            'team' => $nav->getUser()->currentTeam,
        ]);
    }
}
