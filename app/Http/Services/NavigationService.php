<?php

namespace App\Http\Services;

class NavigationService
{
    private $user;
    private $isUserAdmin;
    private $userTeam;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->isUserAdmin = auth()->user()->hasRole("Admin");
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

    public function getUserTeam()
    {
        return $this->userTeam;
    }

    public function redirectToDashboardIfUserIsNotAdmin()
    {
        if (!$this->isUserAdmin) {
            return redirect()->route('dashboard');
        }
    }
}
