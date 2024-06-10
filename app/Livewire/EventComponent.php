<?php

namespace App\Livewire;

use App\Http\Services\EventService;
use Livewire\Attributes\On;
use Livewire\Component;

class EventComponent extends Component
{
    public $selectedUsers = [];

    #[On('aUserHasBeenSelected')]
    public function refetchEvents($data)
    {
        $eventService = new EventService(auth()->user());
        $eventsData = $eventService->allEvents($data);

        return response()->json($eventsData);
    }

    public function render()
    {
        return view('livewire.event-component');
    }
}
