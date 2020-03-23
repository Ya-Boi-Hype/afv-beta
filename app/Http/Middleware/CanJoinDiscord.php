<?php

namespace App\Http\Middleware;

use Closure;

class CanJoinDiscord
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
        if ($user->rating_atc == 'SUP' || $user->rating_atc == 'ADM' || in_array('Facility Engineer', $user->permissions)) {
            return $next($request);
        }

        return redirect()->route;
    }
}
