<?php

namespace App\Livewire;

use App\Models\Team;
use App\Models\User;
use App\Models\Events;
use Livewire\Component;
use App\Models\Calendarobject;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;


class Calendar extends Component
{
    public $events = [];
    public $icsUser = [];
    public $icsGroup = [];
    public $icsTeam = [];
    public $calendarUrl = ['User' => '', 'Group' => '', 'Team' => []];
    public $choiceUser = [
        'User' => true,
        'Group' => true,
        'Team'=>[],
    ];
    public $teamUsers=[];
    public $teamId;
    public $userTeamIds;
    
    public $colorTeam = [
    "#FF0000", // Rouge
    "#FFA500", // Orange
    "#FFFF00", // Jaune
    "#800080", // Violet
    "#FFC0CB", // Rose
    "#A52A2A", // Marron
    "#808080", // Gris
    "#FF4500", // Orange Rouge
    "#D2691E", // Chocolat
    "#DC143C", // Cramoisi
    "#FFD700", // Or
    "#ADFF2F", // Vert Jaune
    "#FF69B4", // Rose Vif
    "#CD5C5C", // Indian Red
    "#F08080", // Light Coral
    "#FA8072", // Saumon
    "#E9967A", // Dark Salmon
    "#FFA07A", // Light Salmon
    "#FFDEAD", // Navajo White
    "#FFE4B5", // Moccasin
    "#F5DEB3", // Blé
    "#FFFACD", // Lemon Chiffon
    "#FAFAD2", // Light Goldenrod Yellow
    "#FFEFD5", // Papaya Whip
    "#FFEBCD", // Blanched Almond
    "#FFDAB9", // Peach Puff
    "#EEE8AA", // Pale Goldenrod
    "#F0E68C", // Khaki
    "#BDB76B", // Dark Khaki
    "#BC8F8F", // Rosy Brown
    "#8B4513", // Saddle Brown
    "#D2B48C", // Tan
    "#D2691E", // Chocolate
    "#B22222", // Firebrick
    "#A52A2A", // Brown
    "#E9967A", // DarkSalmon
    "#FA8072", // Salmon
    "#FFA07A", // LightSalmon
    "#FF4500", // OrangeRed
    "#FF6347", // Tomato
    "#FF7F50", // Coral
    "#FF8C00", // DarkOrange
    "#FFA500", // Orange
    "#FFD700", // Gold
    "#FFFF00", // Yellow
    "#FFFFE0", // LightYellow
    "#FFFACD", // LemonChiffon
    "#FAFAD2", // LightGoldenrodYellow
    "#FFEFD5", // PapayaWhip
    "#FFE4B5", // Moccasin
    "#FFDAB9", // PeachPuff
    "#EEE8AA", // PaleGoldenrod
    "#F0E68C", // Khaki
    "#BDB76B"  // DarkKhaki
    ];
    public $color = [
        'User' => 'blue',
        'Group' => 'green',
        'Team' => []
    ];
   




    public function getEvents($submit=null, )
    {
        $user = auth()->user();
        $teamId = $user->getTeamFocus();




        if ($user->isAdmin() || $user->canDoAction("Moderateur", $this->teamId)) {
        foreach ($this->choiceUser['Team'] as $key => $bool) {
            $userTeam= User::where('id',$key)->first();
            if ($bool == false) {
                if (array_key_exists($key, $this->icsTeam)) {
                    unset($this->icsTeam[$key]);
                }
                if (array_key_exists($key, $this->calendarUrl['Team'])) {
                    unset($this->calendarUrl['Team'][$key]);
                }

                
            }
            else if( $bool == true) {
                if (array_key_exists($key, $this->icsTeam)) {
                    unset($this->icsTeam[$key]);
                }
                if (array_key_exists($key, $this->calendarUrl['Team'])) {
                    unset($this->calendarUrl['Team'][$key]);
                }
                $this->calendarUrl['Team'][$key]= [$userTeam->name, $userTeam->getCalendarUrl()];
                $icsTeam = $userTeam->getEvents();
                foreach ($icsTeam as $ics) {
                    $this->icsTeam[$key][] = $this->calendarUrl['Team'][$key][1] . '/' . $ics->uri;
                };   
            }
        }  
    }
       

       
        if ($this->choiceUser["User"] == !false) {
            $this->icsUser = [];
            $this->calendarUrl['User'] = '';


            $this->calendarUrl['User'] = $user->getCalendarUrl();

            $icsUser = $user->getEvents();

            foreach ($icsUser as $ics) {
                $this->icsUser[] = $this->calendarUrl['User'] . '/' . $ics->uri;
            };
        } else {

            $this->icsUser = [];
            $this->calendarUrl['User'] = '';
        }

        if ($this->choiceUser["Group"] == !false) {
            $this->icsGroup = [];
            $this->calendarUrl['Group'] = '';


            

            $team = Team::where('id', $teamId)->first();

            $this->calendarUrl['Group'] = $team->getCalendarUrl();


            $icsGroup = $team->getEvents();

            // dd($icsGroup);
            foreach ($icsGroup as $ics) {
                $this->icsGroup[] = $this->calendarUrl['Group'] . '/' . $ics->uri;
            };
        } else {
            $this->icsGroup = [];
            $this->calendarUrl['Group'] = '';
        };

        if ($submit=='submit'){
            
            $this->dispatch('refresh');
        }
        
        
    }

    public function render()
    {
        $user=auth()->user();
        $this->teamId = $user->getTeamFocus();

        if ($user->isAdmin() || $user->canDoAction("Moderateur",$this->teamId)){
            if ($user->isAdmin()){
            $this->teamUsers=Team::where('id',$this->teamId)->first()->users()->wherePivot('role', '!=', 1)->get();
        }
        else if ($user->canDoAction("Moderateur",$this->teamId)){
            $this->teamUsers = Team::where('id', $this->teamId)->first()->users()->wherePivot('role', '!=', 1)->where('id','=!', $user->id)->get();
        }
        $x = 0;    
        foreach ($this->teamUsers as $teamUser) {
                if (!isset($this->choiceUser['Team'][$teamUser->id])) {
                    
                    $this->choiceUser['Team'][$teamUser->id] = true;
                    $this->color['Team'][$teamUser->id] = $this->colorTeam[$x];
                    $x++;
                    $this->userTeamIds[]=$teamUser->id;
                }
            }  
        }

        $this->getEvents();
        // dd($this->teamUsers);

        


        return view('livewire.calendar');
    }
}