<?php

namespace App\Livewire;

class TeamMembersCheckbox extends Calendar
{
    public $allTeamMembersSelected;

    public $teamMembers;

    public function mount()
    {
        parent::mount();
    }

    public function checkedBox()
    {
        $this->dispatch('aUserHasBeenSelected', $this->selectedUsers);
    }

    public function allCheckedBox()
    {
        if ($this->allTeamMembersSelected) {
            $this->selectedUsers = $this->teamMembers->pluck('id')->toArray();
        } else {
            $this->selectedUsers = [];
        }

        $this->dispatch('aUserHasBeenSelected', $this->selectedUsers);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        if ($this->team != null) {

            $this->teamMembers = $this->team->users()->where('role', '!=', 1)->get();

        }

        return view('livewire.team-members-checkbox');
    }
}
