<?php

namespace App\Http\Services;

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
        $allUsersEvents = [];

        foreach ($selectedUsers as $selectedUser) {
            $eventQuery = Events::query();
            $eventQuery->where('user_id', $selectedUser);
            $events = $eventQuery->get();
            $existingsEventsIDs = [];
            if ($events) {

                foreach ($events as $event) {

                    if (! (int) $event['is_all_day']) {
                        $event['allDay'] = false;
                        $event['start'] = $event['start'];
                        $event['end'] = $event['end'];
                        $event['endDay'] = $event['end'];
                        $event['startDay'] = $event['start'];
                    } else {
                        $event['allDay'] = true;
                        $event['endDay'] = $event['end'];
                        $event['end'] = $event['end'];
                        $event['startDay'] = $event['start'];
                    }
                    array_push($allUsersEvents, $event);
                    array_push($existingsEventsIDs, $event->event_id);
                }
            }
        }

        return $allUsersEvents;
    }
}
