<?php

namespace App\Livewire;
use App\Models\Role;
use App\Models\User;
use Google\Service\ServiceControl\Auth;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\TeamInvitation;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;

class UsersTable extends TeamMemberManager
{
    
    // public string $search = '';
    


    // public function increment()
    // {
    //     $this->count++;
    // }

    // // A parler avec clement, pb d'actualisation de livewire
    public function updateSearch()
    {



        $this->render();

    }
    public function setFormValues($role,$email)
    {
        $this->addTeamMemberForm['role'] =$role ;
        $this->addTeamMemberForm['email'] = $email;

        // dd($this->addTeamMemberForm['role'] ,$this->addTeamMemberForm['email']);
    }

    /**
     * Add a new team member to a team.
     *
     * @return void
     */
    public function addTeamMember()
    {
        $userIdInvite = User::where('email', $this->addTeamMemberForm['email'])->first()->id;
        $this->resetErrorBag();
        $rules = [
            'addTeamMemberForm.email' => ['required', 'email'],
            'addTeamMemberForm.role' => ['required', 'not_in:Admin'],
        ];
       
        $messages = [
            'addTeamMemberForm.email.required' => 'L\'email est requis',
            'addTeamMemberForm.email.email' => 'L\'email doit être une adresse email valide',
            'addTeamMemberForm.role.required' => 'Le role est requis',
            'addTeamMemberForm.role.not_in' => 'Le rôle Admin n\'est pas autorisé.',
        ];
    
        $this->validate($rules, $messages);
    

        

        if (Features::sendsTeamInvitations()) {

            
            if ($this->team->users->contains($userIdInvite)) {
                $this->addError('addTeamMemberForm', 'Cet utilisateur est déja dans l\'équipe');
                return;
            }
            
            try {
                $teamId = $this->team->id;
                $newTeamInvitation = new TeamInvitation([

                    'email' => $this->addTeamMemberForm['email'],
                    'role' => $this->addTeamMemberForm['role'],

                ]);
                $newTeamInvitation->team_id = $teamId;
                $newTeamInvitation->user_id = $userIdInvite;
                $newTeamInvitation->user_id_createInvite = auth()->user()->id;
                $newTeamInvitation->save();
            } catch (\Throwable $th) {
            //    dd($th);
               if ($th->getCode() == 23000) {
                $this->addError('addTeamMemberForm', 'Cet utilisateur est déja dans l\'équipe');
               } 
            }
                

            
            // app(InvitesTeamMembers::class)->invite(
            //     $this->user,
            //     $this->team,
            //     $this->addTeamMemberForm['email'],
            //     $this->addTeamMemberForm['role']
            // );
        } 
        
        $this->addTeamMemberForm = [
            'email' => '',
            'role' => null,
        ];

        $this->team = $this->team->fresh();

        $this->dispatch('saved');
    }

    public function setRole($role, $user, $teamId)
    {
        // dd($role);
        $teamUser= User::find($user)->teams->find($teamId)->membership;
        // $teamUser=User::find($user)->teams->find($teamId)->membership->first();
        // dd($success);
        $teamUser->role = $role;
        $teamUser->save();
        // dd('ok');
        $this->dispatch('good');
    }




    

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
      
        return view('teams.team-member-manager',[
            'users' => User::where('email', 'LIKE', "%{$this->addTeamMemberForm['email']}%")->where('id', '!=', auth()->user()->id)->where(
                'name','!=','Admin')->get(),
            'roleTest' => Role::where('name', '!=', "Admin")->get()
        ]);
    }
}
 