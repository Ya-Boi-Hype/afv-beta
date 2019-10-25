<?php

namespace App\Http\Middleware;

use Closure;

class FacilityEngineer
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
        $user = auth()->user();
        if (in_array('Facility Engineer', $user->permissions)) {
            return $next($request);
        }

        return redirect()->route;
    }
}
