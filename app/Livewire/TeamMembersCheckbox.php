<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;

class TeamMembersCheckbox extends TeamMemberManager
{
    public $selectedUsers = [];

    public function checkedBox()
    {
        $this->dispatch('aUserHasBeenSelected', $this->selectedUsers);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.team-members-checkbox', [
            'users' => User::where('email', 'LIKE', "%{$this->addTeamMemberForm['email']}%")->where('id', '!=', auth()->user()->id)->where(
                'name',
                '!=',
                'Admin'
            )->get(),
            'roleTest' => Role::where('name', '!=', 'Admin')->get(),
        ]);
    }
}
