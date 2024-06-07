<?php

namespace App\Livewire;

use App\Models\Team;
use App\Models\Events;
use Livewire\Component;
use App\Models\Calendarobject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Calendar extends Component
{




    public $events = [];
    public $allIcsEvents = [
        'User' => [],
        'Group' => [],
        'Name' => [],
    ];
    public $calendarUrl=['User'=>'','Group'=>'','Name'=>''];
    public $choiceUser = [
        'User' => true,
        'Group' => false,
        'Name' => false,
    ];
   


    public function checkboxChanged()
    {
        $user = false;
        $group = false;
        if ($this->choiceUser['User'] == true) {
            $user=true;
        }
        if ($this->choiceUser['Group'] == true) {
            $group=true;
        }
        $this->getEvents($user,$group);
        
    }

    public function getEvents(){

        $user = auth()->user();
       
        
    //    $this->allIcsEvents = [
    //     'User' => [],
    //     'Group' => [],
    //     'Name' => [],
    // ];
    // $this->calendarUrl=['User'=>'','Group'=>'','Name'=>''];


        if ($this->choiceUser["User"]==!false){
           
           
            $this->calendarUrl['User']=$user->getCalendarUrl();
            $icsUser=$user->getEvents();
            foreach ($icsUser as $ics){
                $this->allIcsEvents['User'][]=$this->calendarUrl['User'] . '/' . $ics->uri;
                
            };
        }
        else {
            $this->allIcsEvents['User']=[];
            $this->calendarUrl['User']='';
        }

        if ($this->choiceUser["Group"] == !false){
            
            
            $teamId=$user->getTeamFocus();
            $team=Team::where('id',$teamId)->first();
            
            $this->calendarUrl['Group']=$team->getCalendarUrl();
            
            $icsGroup=$team->getEvents();
            // dd($icsGroup);
            foreach ($icsGroup as $ics){
                $this->allIcsEvents['group'][]=$ics;
            };

        
        }
        else {
            $this->allIcsEvents['Group'] = [];
            $this->calendarUrl['Group'] = '';
            
        } 
        
        return $this->allIcsEvents;
        
    }
    public function allIcsEventsUpdated()
    {
        $this->dispatchBrowserEvent('allIcsEventsUpdated', ['allIcsEvents' => $this->allIcsEvents]);
    }


    

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        
        
        $this->getEvents();



        //de base 


       
        return view('livewire.calendar');
    }
}
