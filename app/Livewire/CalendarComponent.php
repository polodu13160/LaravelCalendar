<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Calendarobject;
use App\Http\Services\EventService;
use App\Http\Services\NavigationService;

class CalendarComponent extends Component
{
    public $events = [];

    public $allUrlIcsEvents = [];
    public $namesUsers = [];

    public $calendarUrls = [];
    public $calendarUrlUserConnected = "";
    public $team;
    public $allColors = [
        '#FF5733', // Rouge vif
        '#33FF57', // Vert clair
        '#3357FF', // Bleu clair
        '#F333FF', // Violet
        '#33FFF3', // Cyan
        '#F3FF33', // Jaune
        '#FF3380', // Rose
        '#80FF33', // Lime
        '#3380FF', // Bleu azur
        '#8333FF', // Indigo
        '#FF8333', // Orange
        '#33FF83', // Menthe
        '#FF338F', // Magenta
        '#338FFF', // Bleu ciel
        '#FFC133', // Or
        '#33FFC1', // Turquoise
        '#C1FF33', // Chartreuse
        '#FF33C1', // Rose bonbon
        '#C133FF', // Améthyste
        '#33C1FF', // Bleu piscine
        '#FF5733', // Corail
        '#5733FF', // Lavande
        '#33FF57', // Vert pomme
        '#FF3357', // Saumon
        '#57FF33', // Vert néon
        '#3357FF', // Bleu roi
        '#F35733', // Tangerine
        '#33F357', // Jade
        '#5733F3', // Violet foncé
        '#F33357', // Rouge cerise
    ];
    public $colorByUserAndTeam = [];

    #[On('aUserHasBeenSelected')]
    public function fetchEvents($selectedUsers, $selectedTeam=false)
    {
        $this->allUrlIcsEvents = [];
        $this->calendarUrls = [];

        $this->events = json_encode($this->refetchEvents($selectedUsers));

        foreach ($selectedUsers as $userId) {
            $user = User::find($userId);
            if ($userId!==strval(auth()->user()->id)){

                $this->calendarUrls[$userId] = $user->getCalendarUrl();
            }
            $events=$user->getEvents();
            foreach ($events as $event) {
                if ($userId == auth()->user()->id) {
                    $this->allUrlIcsEvents[$userId][] = auth()->user()->getCalendarUrl() . "/" . $event->uri;
                }
                else {
                $this->allUrlIcsEvents[$userId][] = $this->calendarUrls[$userId] . "/" . $event->uri;
                }

            }

        }
        if ($selectedTeam){
            $this->calendarUrls['team'] = $this->team->getCalendarUrl();
            $events=$this->team->getEvents();
            foreach ($events as $event) {
                $this->allUrlIcsEvents['team'][] = $this->team->getCalendarUrl() . "/" . $event->uri;
            }
        }


        $this->dispatch('eventsHaveBeenFetched');
    }
    public function modificationEvent($event)
    {

    }
    

    public function colorsAttribution()
    {
       $usersTeam= $this->team->users()->where('role','!=', 1)->get();
        $x = 0;
        foreach ($usersTeam as $user) {
            $this->colorByUserAndTeam[$user->id] = $this->allColors[$x];
            $x++;
            $this->namesUsers[$user->id] = $user->name;

        }
        $this->colorByUserAndTeam['team'] = $this->allColors[$x];
    }


    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        $this->colorsAttribution();


        $this->calendarUrlUserConnected = auth()->user()->getCalendarUrl();
        return view('livewire.calendar-component');

    }
}
