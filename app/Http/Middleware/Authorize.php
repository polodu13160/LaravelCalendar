<?php


namespace App\Http\Middleware;

use App\Http\Services\LaravelSabre;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|mixed|null
     */
    public function handle($request, $next)
    {
        if (!LaravelSabre::check($request)) {
            abort(403);
        }

        return $next($request);
    }
}