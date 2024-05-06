<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class EmailSearch extends Component
{
    public $search = '';

    public function render()
    {
        dump($this->search);
        return view('livewire.email-search', [
            'usersMails' => User::where('email',$this->search)->get() ,
        ]);
    }
}
