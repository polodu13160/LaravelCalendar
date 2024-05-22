<?php

namespace App\Livewire;

use App\Models\Calendarobject;
use App\Models\Events;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Calendar extends Component
{
    public $events = [];
    public $allUrlIcsEvents = [];
    public $calendarUrl;

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        $this->events = json_encode(Events::all());
        
        $laravelSabreRoot = config('app.laravelSabreRoot');
        $appRoot = config('app.appRoot');
        $user = auth()->user();
        $userName = $user->username;
        $hashUserName = $user->hashUserName();
        $calendar = DB::table('calendarinstances')->where('principaluri', 'LIKE', '%/' . $hashUserName)->first();

        $calendarId = $calendar->calendarid;
        $this->calendarUrl = $appRoot . '/' . $laravelSabreRoot . '/calendars' . '/' . $hashUserName . '/' . $calendar->uri;
        $calendarobjectsUser = Calendarobject::where('calendarid', $calendarId)->get();

        foreach ($calendarobjectsUser as $calendarobject) {
            $ics = $calendarobject->uri; //cest les données brut d'un fichier ics la 
            $this->allUrlIcsEvents[] = $this->calendarUrl . '/' . $ics;
        }

        return view('livewire.calendar');
    }
}
