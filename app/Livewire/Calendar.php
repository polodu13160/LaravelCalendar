<?php

namespace App\Livewire;

use App\Models\Calendarobject;
use App\Models\Events;
use ICal\Event;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use ICal\ICal;

class Calendar extends Component
{
    public $events = [];
    public $allUrlIcsEvents= [];

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        
        $laravelSabreRoot= config('app.laravelSabreRoot');
        $appRoot= config('app.appRoot');
        $user= auth()->user();
        $userName= $user->username;
        $calendar= DB::table('calendarinstances')->where('principaluri', 'LIKE', '%/' . $userName)->first();
        if (!$calendar) {
            dd('ok');
            $this->events = Events::all();
            return view('livewire.calendar');
        }
        $calendarId = $calendar->calendarid;
        $urlBaseUser=$appRoot . '/' . $laravelSabreRoot . '/calendars' . '/' . $user->username . '/' . $calendar->uri ;
       
        $calendarobjectsUser = Calendarobject::where('calendarid', $calendarId)->get();
        foreach($calendarobjectsUser as $calendarobject){
            $ics= $calendarobject->uri; //cest les données brut d'un fichier ics la 
            $this->allUrlIcsEvents[]=$urlBaseUser . '/' . $ics;
        }
      
        


        // dd($ics);



        





        
        return view('livewire.calendar');
    }
}
