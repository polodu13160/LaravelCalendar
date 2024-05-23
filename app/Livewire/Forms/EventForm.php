<?php

namespace App\Livewire\Forms;

use App\Models\Events;
use GuzzleHttp\Client;
use Livewire\Form;

class EventForm extends Form
{
    public ?Events $events;

    // #[Validate('required')]
    public int $user_id = 1;

    // #[Validate('required')]
    public string $title = '';

    // #[Validate('required')]
    public string $event_id = '';

    // #[Validate('required')]
    public string $start = '';

    // #[Validate('required')]
    public string $end = '';
    
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
        $this->storeiCalEvent();
        $this->visibility = $this->visibility === '1' ? 'private' : 'public';
        // $this->validate();
        Events::create($this->only(['title', 'description', 'event_id', 'user_id', 'start', 'end', 'status', 'is_all_day', 'visibility']));
    }

    public function storeiCalEvent() {

        // Créer un nouveau client Guzzle
        $client = new Client();

        $url = $this->calendarUrl . $this->title . ".ics";
        dd($this->calendarUrl);
        // Définir l'URL de l'événement sur le serveur Sabre/dav
        // $url = 'http://localhost/dav/calendars/6fa5bf2dd665bfd42687/lecalendrierdeAdmin/LaraconOnline.ics';
    }

    public function update()
    {
        $this->visibility = $this->visibility === '1' ? 'private' : 'public';
        $this->events->
        update($this->only(['title', 'description', 'event_id', 'user_id', 'start', 'end', 'status', 'is_all_day', 'visibility']));
    }
}
