<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AccesSabreJustAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Str::startsWith($request->path(), config('app.laravelSabreRoot').'/calendars')) {

            return $next($request);
        }
        if (Auth::user()) {

            // Si l'URL de la requête se termine par '.ics', autoriser l'accès
            if (substr($request->path(), -4) === '.ics') {
                return $next($request);
            }
        }
        if (! Auth::user()->hasRole('Admin')) {
            return redirect('/')->with('alert', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        return $next($request);
    }
}
