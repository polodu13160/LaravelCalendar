<?php

use App\Http\Controllers\DAVController;
use App\Http\Middleware\AccesSabreJustAdmin;
use App\Livewire\AdminController;
use App\Livewire\Calendar;
use App\Livewire\CreateTeamController;
use App\Livewire\CreateUserController;
use App\Livewire\TeamSettingsController;
use App\Livewire\Welcome;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/', Welcome::class)->name('welcome');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/calendar', Calendar::class)->name('calendar');

    Route::get('/admin', AdminController::class)->name('admin');

    Route::get('/teams/create', CreateTeamController::class)->name('teams_create');
    Route::get('/teams/{team}', TeamSettingsController::class)->name('teams_settings');
    Route::get('/user/create', CreateUserController::class)->name('user_create');

    Route::get('/current-team', function () {
        return redirect(url()->previous());
    })->name('current_team');
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

Route::any('/'.$urlName.'/'.'calendars'.'/'.'{path}', [DAVController::class, 'init'])
    ->name('sabre.dav.calendars.user')
    ->where('path', '(.)*')->withoutMiddleware(AccesSabreJustAdmin::class);

Route::any('/'.$urlName.'{path?}', [DAVController::class, 'init'])
    ->name('sabre.dav')
    ->where('path', '(.)*')->middleware(AccesSabreJustAdmin::class);
