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
        $this->allUrlIcsEvents = [];
        $this->calendarUrls = [];

        $EC = new EventComponent();
        $this->events = json_decode($EC->refetchEvents($selectedUsers));

        foreach ($selectedUsers as $userId) {
            

            $user = User::find($userId);
            $auth = auth()->user();

            if ($userId != $auth->id) {

                foreach ($this->events as $event) {

                    if (! $auth->isAdmin()) {
                        $this->isEventPrivate($event);
                    }

                    if (! $auth->isAdmin() && ! $auth->isLeader($this->team->id)) {
                        $this->isEventConfidential($event);
                    }
                }

                $this->calendarUrls[$userId] = $user->getCalendarUrl();
            }

            // $events = $user->getEvents();

            // foreach ($events as $event) {

            //     if ($userId == auth()->user()->id) {
            //         $this->allUrlIcsEvents[$userId][] = $auth->getCalendarUrl().'/'.$event->uri;
            //     } else {
            //         $this->allUrlIcsEvents[$userId][] = $this->calendarUrls[$userId].'/'.$event->uri;
            //     }
            // }
        }

        $this->dispatch('eventsHaveBeenFetched');
    }

    public function status($value)
    {
        $status = require 'app/Tableaux/Status.php';

        return $status[$value];
    }

    public function updateEvent($eventID, $start, $end, $isAllDay = false)
    {
        $event = Events::find($eventID);

        if ($isAllDay) {
            $start = Carbon::parse($start)->startOfDay();
            $end = Carbon::parse($start)->endOfDay();
        }
        $event->update([
            'start' => Carbon::parse($start),
            'end' => Carbon::parse($end),
            'is_all_day' => $isAllDay,
        ]);
    }

    public function setTimeZone($timezone)
    {
        $this->timezone = $timezone;
    }

    // Functions de conditions d'affichage

    public function isEventPrivate($event)
    {
        if ($event->visibility == 'private') {
            $event->title = 'Privé';
            $event->description = 'Cet événement est privé';
            $event->category = 'Privé';
        }
    }

    public function isEventConfidential($event)
    {
        if ($event->visibility == 'confidential') {
            $event->title = 'Confidentiel';
            $event->description = "Vous n'avez pas les droits pour voir cet événement";
        }
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
