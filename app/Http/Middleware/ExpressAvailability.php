<?php

namespace App\Http\Middleware;

use Closure;

class ExpressAvailability
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
        if (auth()->user()->pending && ! auth()->user()->approval->available) { // User is approved
            return $next($request);
        }

        return redirect(route('home'))->withError(['Unauthorized', 'Only members with pending requests can access that link.']);
    }
}
