<?php

namespace App\Livewire;

use App\Http\Services\EventService;
use Livewire\Component;

class EventComponent extends Component
{
    public $selectedUsers = [];

    public function refetchEvents()
    {
        $eventService = new EventService(auth()->user());
        $eventsData = $eventService->allEvents($this->selectedUsers);

        return response()->json($eventsData);
    }

    public function render()
    {
        return view('livewire.event-component');
    }
}
