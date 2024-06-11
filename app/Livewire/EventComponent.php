<?php

namespace App\Livewire;

use App\Http\Services\EventService;
use Livewire\Attributes\On;
use Livewire\Component;

class EventComponent extends Component
{
    #[On('aUserHasBeenSelected')]
    public function refetchEvents($data = null)
    {
        if (!$data) {
            $data = [0];
        }
        $eventService = new EventService(auth()->user());
        $eventsData = $eventService->allEvents($data);
        $this->dispatch('eventsHaveBeenFetched', response()->json($eventsData));

        return response()->json($eventsData);
    }

    public function render()
    {
        return view('livewire.event-component');
    }
}
