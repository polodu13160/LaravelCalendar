<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;

class TeamMembersCheckbox extends TeamMemberManager
{
    public $selectedUsers = [];
    public $team;
    public $userTeam;
    public $selectedAll;
    public $selectedTeam;


    public function checkedBox()
    {
        $this->dispatch('aUserHasBeenSelected', $this->selectedUsers,$this->selectedTeam);
    }
    public function allCheckedBox()
    {
        // dd($this->selectedUsers);
        if ($this->selectedAll) {
            $x = 0;
            foreach ($this->userTeam as $user) {
                $this->selectedUsers[$x] = "$user->id";
                $x++;
            }
            $this->selectedTeam=true;

        }
        else {
            $this->selectedUsers = [];
            $this->selectedTeam = false;
        }
        $this->dispatch('aUserHasBeenSelected', $this->selectedUsers,$this->selectedTeam);
        
        // dd($this->selectedUsers);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        
        $this->userTeam=$this->team->users()->where('role','!=', 1)->get();
       
        return view('livewire.team-members-checkbox');
    }
}
