<?php

use App\Http\Controllers\EventController;
use App\Livewire\Calendar;
use App\Livewire\EventComponent;
use Illuminate\Support\Facades\Route;

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
