<?php

namespace App\Livewire;

use App\Http\Services\EventService;
use Livewire\Component;

class EventComponent extends Component
{
    public function refetchEvents($data = null)
    {
        if (! $data) {
            $data = [0];
        }
        $eventService = new EventService(auth()->user());
        $eventsData = $eventService->allEvents($data);

        return response()->json($eventsData);
    }

    // public function render()
    // {
    //     return view('livewire.event-component');
    // }
}
