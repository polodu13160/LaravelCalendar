<?php

use Sabre\DAV\Server;
use App\Livewire\Calendar;
use App\Livewire\EventComponent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\ServeurControllers;

Route::get('/', function () {
    return view('welcome');
});

Route::any('/sabredav', [ServeurControllers::class, 'handle']);
Route::any('/sabredav/{any}', [ServeurControllers::class, 'handle'])->where('any', '.*')->name('calendrierTest');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {

    Route::get('/dashboard', function () {

        return view('dashboard');
    })->name('dashboard');

    Route::get('/calendar', function () {
        return view('calendar');
    })->name('calendar');

    // Route::get('refetch-events', EventComponent::class)->name('refetch-events');
});
