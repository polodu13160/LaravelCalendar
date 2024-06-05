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
    protected $listeners = ['allIcsEventsUpdated' => 'allIcsEventsUpdated'];



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

    private function getEvents($user=false, $group=false,$name=false, ){
        
        
       $this->allIcsEvents = [
        'User' => [],
        'Group' => [],
        'Name' => [],
    ];
    $this->calendarUrl=['User'=>'','Group'=>'','Name'=>''];


        if ($user==!false){
            $user=auth()->user();
            $this->calendarUrl['User']=auth()->user()->getCalendarUrl();
            $icsUser=auth()->user()->getEvents();
            foreach ($icsUser as $ics){
                $this->allIcsEvents['User'][]=$this->calendarUrl['User'] . '/' . $ics->uri;
                
            };
        }
        if ($group==!false){
            
            $teamId=auth()->user()->getTeamFocus();
            $team=Team::where('id',$teamId)->first();
            $this->calendarUrl['Group']=$team->getCalendarUrl();
            
            $icsGroup=$team->getEvents();
            foreach ($icsGroup as $ics){
                $this->allIcsEvents['group'][]=$ics;
            };

        
        }; 
        
        
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
        
        
        $this->getEvents($this->choiceUser['User'],$this->choiceUser['Group'],$this->choiceUser['Name']);



        //de base 


       
        return view('livewire.calendar');
    }
}
