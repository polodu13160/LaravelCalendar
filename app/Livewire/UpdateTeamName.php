<?php

namespace App\Livewire;

use Laravel\Jetstream\Http\Livewire\UpdateTeamNameForm;

class UpdateTeamName extends UpdateTeamNameForm
{
    public function render()
    {
        $abstract = new AbstractComponent();
        $abstract->mount();

        return view('livewire.update-team-name')->with([
            'isAdmin' => $abstract->isLoggedUserAdmin(),
            'isModerator' => $abstract->isLoggedUserModerator(),
        ]);
    }
}
