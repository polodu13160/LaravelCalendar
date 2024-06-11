<?php

namespace App\Http\Controllers;

use App\Http\Services\NavigationService;

class WelcomeController
{
    public $calendarUrl;
    public function index()
    {
        $nav = new NavigationService();
        $nav->setCalendarUrl();
        $this->calendarUrl = $nav->getCalendarUrl();
        return view('welcome')->with([
            'calendarUrl' => $this->calendarUrl,
        ]);
    }
}
