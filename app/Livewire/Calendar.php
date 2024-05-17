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
    public $calendarUrl;

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
        $hashUserName= $user->hashUserName();
        $calendar= DB::table('calendarinstances')->where('principaluri', 'LIKE', '%/' . $hashUserName)->first();
        if (!$calendar) {
            
            $this->events = Events::all();
            return view('livewire.calendar');
        }
        $calendarId = $calendar->calendarid;
        $this->calendarUrl= $appRoot . '/' . $laravelSabreRoot . '/calendars' . '/' . $hashUserName . '/' . $calendar->uri;
        // dd($this->calendarUrl);
        $calendarobjectsUser = Calendarobject::where('calendarid', $calendarId)->get();
        foreach($calendarobjectsUser as $calendarobject){
            $ics= $calendarobject->uri; //cest les données brut d'un fichier ics la 
            $this->allUrlIcsEvents[]=$this->calendarUrl . '/' . $ics;
        }
      
        


        // dd($ics);



        





        
        return view('livewire.calendar');
    }
}
