<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;

class CreateUserController extends AbstractComponent
{
    public $email = null;

    public $password = 'password';

    public $name = null;

    public $username = null;

    public $showTeamSection = false;

    public $role = null;

    public $roles;

    public $teams;

    public function toggleTeamSection()
    {
        $this->showTeamSection = ! $this->showTeamSection;
    }

    public function mount()
    {
        parent::mount();
        $this->team = null;
        $this->teams = Team::all();
        $this->roles = Role::query()->where('id', '!=', '1')->get();

        $this->redirectToDashboardIfNotAdmin();
    }

    public function create()
    {
        if ($this->isLoggedUserAdmin()) {

            if (! $this->showTeamSection) {

                $this->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'unique:users,email'],
                    'username' => ['required', 'string', 'max:255', 'unique:users,username'],
                    'password' => ['required', 'string'],
                ]);

                User::createUser($this->name, $this->email, $this->username, $this->password);
            } else {

                $this->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'unique:users,email'],
                    'username' => ['required', 'string', 'max:255', 'unique:users,username'],
                    'team' => ['required', 'integer', 'exists:teams,id'],
                    'role' => ['required', 'integer', 'exists:roles,id'],
                    'password' => ['required', 'string'],
                ]);

                User::createUser($this->name, $this->email, $this->username, $this->password, $this->team, $this->role);
            }

            return $this->redirectToDashboard();
        }

        return $this->redirectToDashboard();
    }

    public function render()
    {
        if ($this->isLoggedUserAdmin()) {
            return view('livewire.create-user-controller');
        }
    }
}
