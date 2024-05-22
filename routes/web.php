<?php

use App\Livewire\Calendar;
use Illuminate\Routing\Router;
use App\Livewire\EventComponent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DAVController;
use App\Http\Middleware\AccesSabreJustAdmin;
use Spatie\IcalendarGenerator\Components\Calendar as ComponentsCalendar;
use Spatie\IcalendarGenerator\Components\Event;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dd', function () {
    $fetch = new EventComponent();
    dd($fetch->refetchEvents());
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/calendar', Calendar::class)->name('calendar');

    Route::get('refetch-events', EventComponent::class)->name('refetch-events');
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
