<?php

namespace App\Livewire;

use App\Http\Services\NavigationService;
use App\Models\Calendarobject;
use App\Models\Events;
use Livewire\Attributes\On;
use Livewire\Component;

class CalendarComponent extends Component
{
    public $events = [];

    public $allUrlIcsEvents = [];

    public $calendarUrl;

    #[On('eventsHaveBeenFetched')]
    public function fetchEvents($eventsData)
    {
        $this->events = json_encode($eventsData);
        $this->dispatch('GO', $this->events);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        $nav = new NavigationService();
        $nav->setCalendarUrl();
        $this->calendarUrl = $nav->getCalendarUrl();

        $calendarobjectsUser = Calendarobject::where('calendarid', $nav->getCalendar()->calendarid)->get();

        foreach ($calendarobjectsUser as $calendarobject) {

            $ics = $calendarobject->uri; //cest les données brut d'un fichier ics la
            $this->allUrlIcsEvents[] = "$this->calendarUrl/$ics";
        }

        return view('livewire.calendar-component')->with([
            'team' => $nav->getUser()->currentTeam,
        ]);
    }
}
