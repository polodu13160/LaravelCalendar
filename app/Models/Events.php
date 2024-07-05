<?php

namespace App\Models;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Ramsey\Uuid\Uuid;
use Spatie\IcalendarGenerator\Components\Calendar as ComponentsCalendar;
use Spatie\IcalendarGenerator\Components\Event;
use Spatie\IcalendarGenerator\Properties\TextProperty;

class Events extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',
        'end',
        'title',
        'description',
        'is_all_day',
        'visibility',
        'category',
        'user_id',
        'event_id',
        'backgroundColor',
        'borderColor',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function calendarObject(): HasOne
    {
        return $this->hasOne(CalendarObject::class, 'event_id');
    }

    public function createIcs(): void
    {
        $user = $this->user()->first();
        $calendarUrl = $user->getCalendarUrl();
        $uuid = Uuid::uuid1()->toString();
        $uri = $uuid.'.ics';
        $ics = $calendarUrl.'/'.$uri;

        // $this->calendarObject()->create([
        //     'calendar_id' => $this->user()->first()->getCalendarInstance()->id,
        //     'event_id' => $this->id,
        //     'last_modified' => $this->updated_at->getTimestamp(),
        //     'componenttype' => 'VEVENT',
        //     'uid' => $this->id,
        //     'calendar_data' => $this->getIcs(),

        // ]);
        $client = new Client();
        // $url = 'http://localhost/dav/calendars/6fa5bf2dd665bfd42687/lecalendrierdeAdmin/LaraconOnline.ics';

        $test = Event::create()
            ->name($this->title)
            ->description($this->description)
            ->createdAt(Carbon::parse($this->created_at))
            ->startsAt(Carbon::parse($this->start))
            ->endsAt(Carbon::parse($this->end))
            ->appendProperty(TextProperty::create('CATEGORIES', ($this->category)));
        // le remplacer par this->categories (nom de la colonne dans la table events)

        $cal = ComponentsCalendar::create()->event($test)->get();

        $response = $client->request(
            'PUT',
            $ics,
            [
                'body' => $cal,
                'headers' => [
                    'Content-Type' => 'text/calendar; charset=UTF-8',
                    // 'If-None-Match' => '*',
                ],
            ]
        );
        $statusCode = $response->getStatusCode();

        if ($statusCode == 201) {

            $calendarObject = Calendarobject::where('uri', $uri)->first();
            $timestampsOriginal = $this->timestamps;
            $this->timestamps = false;

            $calendarObject->update(['event_id' => $this->id]);
            $this->calendarobject_id = $calendarObject->id;
            $this->updated_at = Carbon::createFromTimestamp($calendarObject->lastmodified);
            $this->save();
            $this->timestamps = $timestampsOriginal;
        }
    }

    public function modificationEventToICS()
    {

        $eventIcs = $this->calendarObject()->first();
        $eventIcs->DELETE();
        $this->createIcs();
    }

    public function modificationIcsToEvent()
    {
        $eventIcs = $this->calendarObject()->first();
        $timestampsOriginal = $this->timestamps;
        $this->timestamps = false;

        $this->update([
            'start' => Carbon::createFromTimestamp($eventIcs->firstoccurence),
            'end' => Carbon::createFromTimestamp($eventIcs->lastoccurence),
            'updated_at' => Carbon::createFromTimestamp($eventIcs->lastmodified),
        ]);

        $this->timestamps = $timestampsOriginal;
    }
}
