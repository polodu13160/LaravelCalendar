<?php

namespace App\Http\Services;

use ICal\ICal;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Events;

class EventService
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function create($data)
    {
        $event = new Events($data);
        $event->save();

        return $event;
    }

    public function update($id, $data)
    {

        $event = Events::find($id);
        $event->fill($data);
        $event->save();

        return $event;
    }

    public function allEvents($selectedUsers)
    {
        $fullCalendarEvents = [];
        $ical = new ICal(false, [
            'defaultSpan'                 => 2,     // Default value
            'defaultTimeZone'             => 'UTC',
            'defaultWeekStart'            => 'MO',  // Default value
            'disableCharacterReplacement' => false, // Default value
            'filterDaysAfter'             => null,  // Default value
            'filterDaysBefore'            => null,  // Default value
            'skipRecurrence'              => false, // Default value
        ]);

        foreach ($selectedUsers as $selectedUser) {
            $user= User::find($selectedUser);
            $events = $user->getEvents();
            $existingsEventsIDs = [];
            if (count($events)>0) {
                foreach ($events as $event){
                    $ical->initString($event->calendardata);
                    $eventParse = $ical->events()[0];
                    dd($eventParse);
                    $start = Carbon::createFromFormat('Ymd\THis', $eventParse->dtstart);
                    $formattedStart = $start->format('Y-m-d H:i:s');
                    $end= Carbon::createFromFormat('Ymd\THis', $eventParse->dtend);
                    $formattedEnd = $end->format('Y-m-d H:i:s');
                    

                    $fullCalendarEvents[]=
                        [
                            'id' => $event->id,
                            'user_id' => $user->id,
                            'start' => $formattedStart,
                            'end' => $formattedEnd,
                            'status' => $eventParse->status,
                            'is_all_day' => $eventParse['ALL_DAY'],
                            'visibility' => $eventParse['CLASS'],
                            'title' => $eventParse['SUMMARY'],
                            'description' => $eventParse['DESCRIPTION'],
                            'background_color' => $eventParse['COLOR'],
                            'border_color' => $eventParse['COLOR'],
                            'event_id' => $event->id,
                            'created_at' => $eventParse['DTSTART'],
                            'updated_at' => $eventParse['DTEND'],
                            'deleted_at' => '',
                        ];
                }

            // $eventQuery = Events::query();
            // $eventQuery->where('user_id', $selectedUser);
            // $events = $eventQuery->get();
            
            // if ($events) {

            //     foreach ($events as $event) {

                    
            //         array_push($existingsEventsIDs, $event->event_id);
            //     }
            // }

        }
        }

        return $fullCalendarEvents;
    }
    

    function parseICalContent($iCalContent)
    {
        $lines = explode("\n", $iCalContent);
        $iCalObject = [];

        foreach ($lines as $line) {
            list($key, $value) = explode(':', $line, 2);
            $iCalObject[$key] = trim($value);
        }

        return $iCalObject;
    }
}
