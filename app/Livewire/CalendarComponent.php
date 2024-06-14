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

    public $calendarUrls = [];
    public $calendarUrlUserConnected = "";
    public $team;

    #[On('aUserHasBeenSelected')]
    public function fetchEvents($selectedUsers, $selectedTeam=false)
    {
        
        $this->events = json_encode($this->refetchEvents($selectedUsers));

        foreach ($selectedUsers as $userId) {
            $user= User::find($userId);
            if ($user==auth()->user()){
                $this->calendarUrlUserConnected= auth()->user()->getCalendarUrl();
            }
            else {
                $this->calendarUrls[$userId] = $user->getCalendarUrl();
            }
        }
        if ($selectedTeam){
            $this->calendarUrls['team'] = $this->team->getCalendarUrl();
        }
        
        $this->dispatch('eventsHaveBeenFetched');
    }
    public function refetchEvents($data = null)
    {
        if (!$data) {
            return response()->json([]);
        }
        else {
            $eventService = new EventService(auth()->user());
            $eventsData = $eventService->allEvents($data);

            return response()->json($eventsData);


        }
        
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
        // $this->calendarUrl = $nav->getCalendarUrl();

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
