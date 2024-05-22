<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\LaravelSabreCalendarHome;
use Laravel\Jetstream\Http\Livewire\CreateTeamForm;
use Laravel\Jetstream\Http\Controllers\Livewire\TeamController;

class TeamControllerJetStream extends CreateTeamForm
{

    public $email=null;
    public string $updateMailTeamOwner;
    public $updateUserTeamOwner=null;
    public $name;
    public $laravelSabreCalendarHome;


public function updateSearchAndUser($email)
{
    
    $this->updateSearch($email);
    $this->updateUserTeamOwnerFunc($email);
}


    

    public function updateSearch($email)
    {
        $this->email= $email;
        return $this->render();
    }
    public function updateUserTeamOwnerFunc($mail)
    {
        $user = User::where('email', $mail)->first();
        $this->updateUserTeamOwner = $user;
    }
    
    public function setFormValues($email)
    {
        $this->email = $email;

        //
    }
    public function setLaravelSabreCalendarHome()
    {
        $this->laravelSabreCalendarHome = new LaravelSabreCalendarHome();
    }

    /**
     * Show the team management screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\View\View
     */
    

    /**
     * Show the team creation screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        
        if (auth()->user()->hasRole('Admin')) {
             $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:teams,name'],
            'email' => ['required', 'email', 'exists:users,email'],
        ]);
        
        $nameTeam=$this->name;
        $user=User::where('email',$this->email)->first();
        // dd($nameTeam,$userMail); 
        $user->createTeamPrincipal($nameTeam);
        
        return redirect()->route('dashboard')->with('status', 'L\'équipe a été créée avec succès !');

           
        }
       
    }
    public function render()
    {
        
        return view('teams.create-team-form', [
            'users' => User::where('email', 'LIKE', "%{$this->email}%")->where('id', '!=', auth()->user()->id)->where(
                'name',
                '!=',
                'Admin'
            )->get(),
            
        ]);
    }
}

