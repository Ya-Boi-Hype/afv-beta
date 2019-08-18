<?php

namespace App\Http\Middleware;

use Closure;

class HasNoRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! auth()->user()->has_request) { // User is approved
            return $next($request);
        }

        return redirect(route('home'))->withError(['Unauthorized', 'You already have a request to join.']);
    }
}
