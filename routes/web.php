<?php

use App\Http\Controllers\DAVController;
use App\Http\Middleware\AccesSabreJustAdmin;
use App\Livewire\Calendar;
use App\Livewire\EventComponent;
use App\Livewire\CreateTeamControllerJetStream;
use GuzzleHttp\Client;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Spatie\IcalendarGenerator\Components\Calendar as ComponentsCalendar;
use Spatie\IcalendarGenerator\Components\Event;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dd', function () {
    $fetch = new EventComponent();
    dd($fetch->refetchEvents());
});

Route::get('/dd2', function () {

    $client = new Client();
    $url = 'http://localhost/dav/calendars/6fa5bf2dd665bfd42687/lecalendrierdeAdmin/LaraconOnline.ics';

    $test = Event::create()
        ->name('Laracon Online')
        ->description('Experience Laracon all around the world')
        ->uniqueIdentifier('A unique identifier can be set here')
        ->createdAt(new DateTime('6 march 2024'))
        ->startsAt(new DateTime('6 march 2024 15:00'))
        ->endsAt(new DateTime('6 march 2024 16:00'));

    $cal = ComponentsCalendar::create()->event($test)->get();

    $response = $client->request('PUT', $url, [
        'body' => $cal,
        'headers' => [
            'Content-Type' => 'text/calendar; charset=UTF-8',
            'If-None-Match' => '*',
        ],
    ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('refetch-events', EventComponent::class)->name('refetch-events');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/calendar', Calendar::class)->name('calendar');

    Route::get('/teams/create', CreateTeamControllerJetStream::class)->name('teams.create');
});

$verbs = [
    'GET',
    'HEAD',
    'POST',
    'PUT',
    'PATCH',
    'DELETE',
    'PROPFIND',
    'PROPPATCH',
    'MKCOL',
    'COPY',
    'MOVE',
    'LOCK',
    'UNLOCK',
    'OPTIONS',
    'REPORT',
];
Router::$verbs = array_merge(Router::$verbs, $verbs);
$urlName = config('app.laravelSabreRoot');

Route::any('/' . $urlName . '/' . 'calendars' . '/' . '{path}', [DAVController::class, 'init'])
    ->name('sabre.dav.calendars.user')
    ->where('path', '(.)*')->withoutMiddleware(AccesSabreJustAdmin::class);

Route::any('/' . $urlName . '{path?}', [DAVController::class, 'init'])
    ->name('sabre.dav')
    ->where('path', '(.)*')->middleware(AccesSabreJustAdmin::class);
