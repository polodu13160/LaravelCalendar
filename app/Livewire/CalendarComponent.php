<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class CalendarComponent extends Component
{
    public $events = [];

    public $allUrlIcsEvents = [];

    public $namesUsers = [];

    public $calendarUrls = [];

    public $calendarUrlUserConnected = '';

    public $team;

    public $colorByUserAndTeam = [];

    #[On('aUserHasBeenSelected')]
    public function fetchEvents($selectedUsers, $selectedTeam = false)
    {
        $this->allUrlIcsEvents = [];
        $this->calendarUrls = [];

        $EC = new EventComponent();
        $this->events = json_encode($EC->refetchEvents($selectedUsers));

        foreach ($selectedUsers as $userId) {
            $user = User::find($userId);
            if ($userId !== strval(auth()->user()->id)) {

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
        if ($selectedTeam) {
            $this->calendarUrls['team'] = $this->team->getCalendarUrl();
            $events = $this->team->getEvents();
            foreach ($events as $event) {
                $this->allUrlIcsEvents['team'][] = $this->team->getCalendarUrl().'/'.$event->uri;
            }
        }

        $this->dispatch('eventsHaveBeenFetched');
    }

    public function modificationEvent($event)
    {

    }

    public function colorsAttribution()
    {
        $usersTeam = $this->team->users()->where('role', '!=', 1)->get();

        foreach ($usersTeam as $user) {
            $this->colorByUserAndTeam[$user->id] = $user->color;

            $this->namesUsers[$user->id] = $user->name;

        }
        $this->colorByUserAndTeam['team'] = '#008000';
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
