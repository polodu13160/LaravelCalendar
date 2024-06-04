<?php

namespace App\Http\Services;

class NavigationService
{
    private $user;
    private $isUserAdmin;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->user = auth()->user()->hasRole("Admin");
    }

    public function redirectToDashboardIfUserIsNotAdmin()
    {
        if (!$this->isUserAdmin) {
            return redirect()->route('dashboard');
        }
    }
}
