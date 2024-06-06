<?php

namespace App\Http\Services;

class NavigationService
{
    private $user;

    private $isUserAdmin;

    private $isUserModerator;

    private $userTeam;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->isUserAdmin = auth()->user()->hasRole('Admin');
        $this->isUserModerator = auth()->user()->hasRole('Moderateur');
        $this->userTeam = auth()->user()->getTeamFocus();
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getIsUserAdmin()
    {
        return $this->isUserAdmin;
    }

    public function getIsUserModerator()
    {
        return $this->isUserModerator;
    }

    public function getUserTeam()
    {
        return $this->userTeam;
    }

    public function redirectToDashboardIfUserIsNotAdmin()
    {
        if (! $this->isUserAdmin) {
            return redirect()->route('dashboard');
        }
    }
}
