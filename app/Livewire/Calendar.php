<?php

namespace App\Livewire;

use App\Models\Team;
use App\Models\Events;
use Livewire\Component;
use App\Models\Calendarobject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;


class Calendar extends Component
{
    public $events = [];
    public $icsUser = [];
    public $icsGroup = [];
    public $icsName = [];
    public $calendarUrl = ['User' => '', 'Group' => '', 'Name' => ''];
    public $choiceUser = [
        'User' => true,
        'Group' => true,
        'Name' => false,
    ];
    public function getEvents($submit=null)
    {



        $user = auth()->user();



        if ($this->choiceUser["User"] == !false) {
            $this->icsUser = [];
            $this->calendarUrl['User'] = '';


            $this->calendarUrl['User'] = $user->getCalendarUrl();

            $icsUser = $user->getEvents();

            foreach ($icsUser as $ics) {
                $this->icsUser[] = $this->calendarUrl['User'] . '/' . $ics->uri;
            };
        } else {

            $this->icsUser = [];
            $this->calendarUrl['User'] = '';
        }

        if ($this->choiceUser["Group"] == !false) {
            $this->icsGroup = [];
            $this->calendarUrl['Group'] = '';


            $teamId = $user->getTeamFocus();

            $team = Team::where('id', $teamId)->first();

            $this->calendarUrl['Group'] = $team->getCalendarUrl();


            $icsGroup = $team->getEvents();

            // dd($icsGroup);
            foreach ($icsGroup as $ics) {
                $this->icsGroup[] = $this->calendarUrl['Group'] . '/' . $ics->uri;
            };
        } else {
            $this->icsGroup = [];
            $this->calendarUrl['Group'] = '';
        };

        if ($submit=='submit'){
            $this->dispatch('refresh');
        }
        
        
    }

    public function render()
    {
        $this->getEvents();
        return view('livewire.calendar');
    }
}