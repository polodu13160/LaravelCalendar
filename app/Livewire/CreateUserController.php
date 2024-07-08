<?php

namespace App\Livewire;

use App\Models\Role;

use App\Models\Team;
use App\Models\User;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Http\Services\LaravelSabreCalendarHome;

class CreateUserController extends Component
{
    public $email = null;
    public $team = null;
    public $password = 'password';
    public $name= null;
    public $username= null;
    public $showTeamSection = false;
    public $role = null;
    public $roles;
    public $teams;

    // public string $updateMailTeamOwner;

    // public $updateUserTeamOwner = null;


    // public $laravelSabreCalendarHome;

    // public function updateSearchAndUser($email)
    // {
    //     $this->updateSearch($email);
    //     $this->updateUserTeamOwnerFunc($email);
    // }

    // public function updateSearch($email)
    // {
    //     $this->email = $email;

    //     return $this->render();
    // }

    // public function updateUserTeamOwnerFunc($mail)
    // {
    //     $user = User::where('email', $mail)->first();
    //     $this->updateUserTeamOwner = $user;
    // }

    // public function setFormValues($email)
    // {
    //     $this->email = $email;
    // }


    // public function setLaravelSabreCalendarHome()
    // {
    //     $this->laravelSabreCalendarHome = new LaravelSabreCalendarHome();
    // }
    public function toggleTeamSection()
    {
        $this->showTeamSection = !$this->showTeamSection;
    }
    public function mount()
    {
        $this->teams= Team::all();
        $this->roles= Role::all()->where('id', '!=', '1');

        $user= auth()->user();
        if (!$user->hasRole('Admin')) {
        redirect()->route('dashboard');
        }

    }

    public function create()
    {
        if (auth()->user()->hasRole('Admin')) {
            if (!$this->showTeamSection) {

                $this->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'unique:users,email'],
                    'username' => ['required', 'string', 'max:255', 'unique:users,username'],
                    'password' => ['required', 'string'],
                ]);

            }
            else {
                $this->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'unique:users,email'],
                    'username' => ['required', 'string', 'max:255', 'unique:users,username'],
                    'team' => ['required', 'integer', 'exists:teams,id'],
                    'role' => ['required', 'integer', 'exists:roles,id'],
                    'password' => ['required', 'string'],
                ]);
            }

            User::createUser($this->name, $this->email, $this->username, $this->password, $this->team, $this->role);


            // $user = User::where('email', $this->email)->first();
            // dd($nameTeam,$userMail);
            // $user->createTeamPrincipal($nameTeam);

            // return redirect()->route('dashboard')->with('alert', "L'équipe a été créée avec succès !");
            return redirect()->route('dashboard');
        }

        // return redirect()->route('dashboard')->with('status', "L'équipe ne peut-être créée avec cet utilisateur !");
        return redirect()->route('dashboard');
    }

    public function render()
    {
        if (auth()->user()->hasRole('Admin')) {
            return view('livewire.create-user-controller');
        }
    }
}
