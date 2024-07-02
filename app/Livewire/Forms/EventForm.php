<?php

namespace App\Livewire\Forms;

use App\Models\Events;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Livewire\Form;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use Spatie\IcalendarGenerator\Enums\Classification;

class EventForm extends Form
{
    public ?Events $events;

    // #[Validate('required')]
    public int $user_id;

    // #[Validate('required')]
    public string $title;

    public $event_id = null;

    // #[Validate('required')]
    public string $start;

    // #[Validate('required')]
    public string $end;

    public string $description = '';

    public int $status = 0;

    public int $is_all_day = 0;

    public string $visibility = 'public';

    public string $backgroundColor = '';

    public string $borderColor = '';

    public function setEvent(Events $events): void
    {
        $this->events = $events;
        $this->user_id;
        $this->title = $events->title;
        $this->description = $events->description;
        $this->event_id = $events->id;
        $this->start = $events->start;
        $this->end = $events->end;
        $this->status = $events->status;
        $this->is_all_day = $events->is_all_day;
        $this->visibility = $events->visibility;
        $this->backgroundColor = $events->backgroundColor;
        $this->borderColor = $events->borderColor;
    }

    public function store(): void
    {
        $this->visibility = $this->visibility === '1' ? 'private' : 'public';
        $this->user_id = auth()->user()->id;
        Events::create($this->only(['title', 'description', 'event_id', 'user_id', 'start', 'end', 'status', 'is_all_day', 'visibility']));
        $this->storeiCalEvent();
    }

    public function storeiCalEvent()
    {
        // Créer un nouveau client Guzzle
        $client = new Client();

        $user = auth()->user();
        $hashUserName = $user->hashUserName();

        $hashTitle = md5($this->title);

        $laravelSabreRoot = config('app.laravelSabreRoot');
        $appRoot = config('app.appRoot');
        $calendar = DB::table('calendarinstances')->where('principaluri', 'LIKE', '%/'.$hashUserName)->first();

        $url = $appRoot.'/'.$laravelSabreRoot.'/calendars'.'/'.$hashUserName.'/'.$calendar->uri.'/'.$hashTitle.'.ics';

        $classification = $this->classification($this->visibility);

        $test = Event::create()
            ->name($this->title)
            ->description($this->description)
            ->uniqueIdentifier($this->event_id)
            ->classification($classification)
            ->createdAt(new DateTime('now'))
            ->startsAt(new DateTime($this->start))
            ->endsAt(new DateTime($this->end));

        $cal = Calendar::create()->event($test)->get();

        $response = $client->request('PUT', $url, [
            'body' => $cal,
            'headers' => [
                'Content-Type' => 'text/calendar; charset=UTF-8',
                'If-None-Match' => '*',
            ],
        ]);
    }

    public function classification($value)
    {

        if ($value === 0) {
            return Classification::public();
        } elseif ($value === 1) {
            return Classification::private();
        } elseif ($value === 2) { // ne sera jamais utilisé car je ne gere que 0 ou 1 sur le form
            return Classification::confidential();
        }
    }

    public function update()
    {
        $this->visibility = $this->visibility === '1' ? 'private' : 'public';
        $this->events->update($this->only(['title', 'description', 'event_id', 'user_id', 'start', 'end', 'status', 'is_all_day', 'visibility']));
    }
}
