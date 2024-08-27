<?php

namespace App\Livewire;

use App\Models\TeamInvitation;

class Invitations extends AbstractComponent
{
    public $invitation;

    public function mount()
    {
        parent::mount();
        $this->invitation = $this->user->TeamInvitation;
    }

    public function acceptInvitation(TeamInvitation $invit, $accept)
    {
        if ($accept) {

            try {

                $this->user->assignRoleAndTeam($invit->role, $invit->team_id);
            } catch (\Throwable $th) {

                return $th;
            }
        }

        $invit->delete();
        $this->js('window.location.reload()');
    }

    public function render()
    {
        return view('livewire.invitations');
    }
}
