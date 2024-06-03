<?php

namespace App\Livewire;

use App\Models\TeamInvitation;
use Livewire\Component;

class Invitations extends Component
{
    public $invitation;

    public $user;

    public function mount()
    {

        $this->invitation = auth()->user()->TeamInvitation;
        $this->user = auth()->user();
    }

    public function acceptInvitation(TeamInvitation $invit, $accept)
    {
        // dd($invit, $accept);
        // dd($this->user->teams);
        // dd($invit);

        if ($accept) {
            try {
                $this->user->assignRoleAndTeam($invit->role, $invit->team_id);
            } catch (\Throwable $th) {
                dd($th);
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
