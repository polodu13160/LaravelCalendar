<?php

namespace App\Livewire;

use App\Models\Events;
use Livewire\Component;

class Calendar extends Component
{
    public $events = [];
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        $this->events = json_encode(Events::all());
        return view('livewire.calendar');
    }
}
