<?php

namespace App\Livewire;

use App\Http\Services\LaravelSabreCalendarHome;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\RedirectsActions;

class CreateTeamController extends AbstractComponent
{

    ////////////////////////////////////////////// Vérifier si ce bloc de code est utilisé

    use RedirectsActions;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * Create a new team.
     *
     * @param  \Laravel\Jetstream\Contracts\CreatesTeams  $creator
     * @return mixed
     */
    public function createTeam(CreatesTeams $creator)
    {
        $this->resetErrorBag();

        $creator->create(Auth::user(), $this->state);

        return $this->redirectPath($creator);
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    //////////////////////////////////////////////

    public $email = null;

    public string $updateMailTeamOwner;

    public $updateUserTeamOwner = null;

    public $name;

    public $laravelSabreCalendarHome;

    public function updateSearchAndUser($email)
    {
        $this->updateSearch($email);
        $this->updateUserTeamOwnerFunc($email);
    }

    public function updateSearch($email)
    {
        $this->email = $email;

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
    }

    public function setLaravelSabreCalendarHome()
    {
        $this->laravelSabreCalendarHome = new LaravelSabreCalendarHome();
    }

    public function mount()
    {
        parent::mount();

        $this->redirectToDashboardIfNotAdmin();
    }

    public function create(Request $request)
    {
        if ($this->isLoggedUserAdmin()) {

            $this->validate([
                'name' => ['required', 'string', 'max:255', 'unique:teams,name'],
                'email' => ['required', 'email', 'exists:users,email'],
            ]);

            $nameTeam = $this->name;
            $user = User::where('email', $this->email)->first();
            $user->createTeamPrincipal($nameTeam);

            return $this->redirectToDashboard();
        }

        return $this->redirectToDashboard();
    }

    public function render()
    {
        if ($this->isLoggedUserAdmin()) {
            return view('livewire.create-team-controller', [
                'users' => User::where('email', 'LIKE', "%{$this->email}%")->where('id', '!=', auth()->user()->id)->where(
                    'name',
                    '!=',
                    'Admin'
                )->get(),
            ]);
        } else {
            return $this->redirectToDashboard();
        }
    }
}
