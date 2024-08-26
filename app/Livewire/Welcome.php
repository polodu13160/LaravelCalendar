<?php

namespace App\Livewire;

class Welcome extends AbstractComponent
{

    public function render()
    {
        return view('livewire.welcome')->layout('layouts.guest')->with([
            'calendarUrl' => $this->calendarUrl,
        ]);
    }
}
