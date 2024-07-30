<?php

namespace App\Livewire;

use App\Models\Events;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class CalendarComponent extends Component
{
    public $events;

    public $allUrlIcsEvents = [];

    public $calendarUrls = [];

    public $calendarUrlUserConnected = '';

    public $team;

    public $timezone;

    #[On('aUserHasBeenSelected')]
    public function fetchEvents($selectedUsers)
    {
        $authUser=auth()->user();
        if (count($selectedUsers) > 1) {
            if (!$authUser->isAdminOrModerateur($this->team)){
                return abort(403, "Vous n'etes qu'un utilisateur, vous ne pouvez pas faire ça");
            }
        }
        $this->allUrlIcsEvents = [];
        $this->calendarUrls = [];



        $EC = new EventComponent();
        $this->events = $EC->refetchEvents($selectedUsers);



        $this->dispatch('eventsHaveBeenFetched');
    }
    public function status($value){
        $statut=require('app/Tableaux/Status.php');

        return $statut[$value];
    }

    public function updateEvent($eventID, $start, $end, $isAllDay = false)
    {
        $event = Events::find($eventID);

        if ($isAllDay) {
            $start = Carbon::parse($start)->startOfDay();
            $end = Carbon::parse($start)->endOfDay();
        }
        $event->update([
            'start' => Carbon::parse($start)->setTimezone('UTC')->toIso8601String(),
            'end' => Carbon::parse($end)->setTimezone('UTC')->toIso8601String(),
            'is_all_day' => $isAllDay,
        ]);
    }

    public function setTimeZone($timezone) {
        $this->timezone = $timezone;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        $this->calendarUrlUserConnected = auth()->user()->getCalendarUrl();

        return view('livewire.calendar-component');
    }
}
