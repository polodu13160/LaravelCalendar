<?php

namespace App\Livewire;

use Livewire\Component;

class Calendar extends Component
{
    public function render()
    {
        $user = auth()->user();
        $team = $user->currentTeam;

        return view('livewire.calendar')->with([
            'team' => $team,
        ]);
    }
}
