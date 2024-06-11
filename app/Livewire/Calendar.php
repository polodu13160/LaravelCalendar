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
    public $name = 'Barry';
    public $events = [];
    
    public function updatedName()
    {
        $this->emit("refreshCalendar");
    }

    public function getNamesProperty()
    {
      return [
        'Barry',
        'Taylor',
        'Caleb',
      ];
    }

    public function getTasksProperty()
    {
        switch ($this->name) {
          case 'Barry':
            return ['Debugbar', 'IDE Helper'];
          case 'Taylor':
            return ['Laravel', 'Jetstream'];
          case 'Caleb':
            return ['Livewire', 'Sushi'];  
        }

        return [];
    }

    public function eventReceive($event)
    {
        $this->events[] = 'eventReceive: ' . print_r($event, true);
    }

    public function eventDrop($event, $oldEvent)
    {
      $this->events[] = 'eventDrop: ' . print_r($oldEvent, true) . ' -> ' . print_r($event, true);
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}