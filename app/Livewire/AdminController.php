<?php

namespace App\Livewire;

class AdminController extends AbstractComponent
{
    public function mount()
    {
        parent::mount();
    }

    public function render()
    {
        return view('livewire.admin-controller');
    }
}
