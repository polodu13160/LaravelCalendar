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
        $this->events = $EC->refetchEvents($selectedUsers);
        foreach ($selectedUsers as $userId) {

            $user = User::find($userId);

            if ($userId != auth()->user()->id) {

                $this->calendarUrls[$userId] = $user->getCalendarUrl();
            }

            $events = $user->getEvents();

            foreach ($events as $event) {

                if ($userId == auth()->user()->id) {
                    $this->allUrlIcsEvents[$userId][] = auth()->user()->getCalendarUrl().'/'.$event->uri;
                } else {
                    $this->allUrlIcsEvents[$userId][] = $this->calendarUrls[$userId].'/'.$event->uri;
                }
            }
        }

        $this->dispatch('eventsHaveBeenFetched');
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
