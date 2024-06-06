<?php

namespace App\Livewire;

use Laravel\Jetstream\Http\Livewire\UpdateTeamNameForm;

class UpdateTeamName extends UpdateTeamNameForm
{
    public $isModerator;

    public $isAdmin;

    public function render()
    {
        return view('livewire.update-team-name');
    }
}
