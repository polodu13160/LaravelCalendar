<?php

namespace App\Livewire\Forms;

use App\Models\Events;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Livewire\Form;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use Spatie\IcalendarGenerator\Enums\Classification;

class EventForm extends Form
{
    public ?Events $events;

    public int $user_id;

    public string $start;
    
    public string $end;
    
    public string $title;
    
    public ?string $description = null;
    
    public string $category = 'RDV';
    
    public string $visibility = 'public';
    
    public string $status = 'Planifié';
    
    public bool $is_all_day = false;
    
    public string $backgroundColor;
    
    public string $borderColor;
    
    /**
     * Définit les règles de validation pour le formulaire.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'user_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|integer',
            'is_all_day' => 'required|boolean',
            'visibility' => 'required|string',
            'category' => 'required|in:RDV,Appel|string',
            'status' => 'required|in:Planifié,Terminé,Replanifié,Manqué,Annulé,Tenu|string',
            'backgroundColor' => 'required|string',
            'borderColor' => 'required|string',
        ];
    }

    public function setEvent(Events $events): void
    {
        $this->events = $events;
        $this->user_id = $events->user_id;
        $this->title = $events->title;
        $this->description = $events->description;
        $this->start = $events->start;
        $this->end = $events->end;
        $this->status = $events->status;
        $this->is_all_day = $events->is_all_day;
        $this->visibility = $events->visibility;
        $this->category = $events->category;
        $this->backgroundColor = $events->backgroundColor;
        $this->borderColor = $events->borderColor;
    }

    public function store(): void
    {
        $user = auth()->user();
        $this->user_id = $user->id;
        $this->backgroundColor = $user->color;
        $this->borderColor = $user->color. 80;
        
        $validatedData = $this->validate();
        Events::create($validatedData);
 
        // $this->storeiCalEvent();
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

        $url = "$appRoot/$laravelSabreRoot/calendars/$hashUserName/$calendar->uri/$hashTitle.ics";

        $classification = $this->classification($this->visibility);

        $test = Event::create()
            ->name($this->title)
            ->description($this->description != null ? $this->description : '')
            ->uniqueIdentifier($this->event_id)
            ->classification($classification)
            ->createdAt(Carbon::now())
            ->startsAt(Carbon::parse($this->start))
            ->endsAt(Carbon::parse($this->end));

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
        $validatedData = $this->validate();
        $this->events->update($validatedData);
    }
}
