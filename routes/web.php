<?php

use App\Livewire\Calendar;
use Illuminate\Routing\Router;
use App\Livewire\EventComponent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use LaravelSabre\Http\Controllers\DAVController;

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

    Route::get('/calendar', function () {
        return view('calendar');
    })->name('calendar');

    // Route::get('refetch-events', EventComponent::class)->name('refetch-events');
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

Route::any('/dav{path?}', [DAVController::class,'init'])
    ->name('sabre.dav')
    ->where('path', '(.)*');
