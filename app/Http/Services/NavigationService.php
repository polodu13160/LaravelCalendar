<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;

class NavigationService
{
    private $user;

    private $isUserAdmin;

    private $isUserModerator;

    private $userTeam;

    private $calendar;

    private $calendarUrl;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->isUserAdmin = $this->user ? auth()->user()->hasRole('Admin') : null;
        $this->isUserModerator = $this->user ? auth()->user()->hasRole('Moderateur') : null;
        $this->userTeam = $this->user ? auth()->user()->getTeamFocus() : null;
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

    public function getCalendar()
    {
        return $this->calendar;
    }

    public function getCalendarUrl()
    {
        return $this->calendarUrl;
    }

    public function setCalendarUrl()
    {
        if (! $this->user) {

            return null;
        }

        $appRoot = config('app.appRoot');
        $laravelSabreRoot = config('app.laravelSabreRoot');

        $hashUserName = $this->user->hashUserName();

        $this->calendar = DB::table('calendarinstances')->where('principaluri', 'LIKE', "%/$hashUserName")->first();

        $this->calendarUrl = "$appRoot/$laravelSabreRoot/calendars/$hashUserName/".$this->calendar->uri;
    }

    public function redirectToDashboardIfUserIsNotAdmin()
    {
        if (! $this->isUserAdmin) {
            return redirect()->route('dashboard');
        }
    }
}
