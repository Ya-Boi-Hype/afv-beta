<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Approved
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
        if (auth()->user() && (auth()->user()->approved || auth()->user()->admin)) { // User is approved
            return $next($request);
        }

        return redirect(route('home'))->withError(['Unauthorized', 'Only approved members may access that resource.']);
    }
}
