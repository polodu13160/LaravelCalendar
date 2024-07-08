<?php

namespace App\Livewire;

use App\Http\Services\EventService;
use App\Models\Events;
use Livewire\Component;

use function Safe\json_encode;

class EventComponent extends Component
{
    public function refetchEvents($data = null)
    {
        if (! $data) {
            $data = [0];
        }
        $eventService = new EventService(auth()->user());
        $eventsData = $eventService->allEvents($data);

        return json_encode($eventsData);
    }

    public function render()
    {
        return view('livewire.event-component');
    }
}
