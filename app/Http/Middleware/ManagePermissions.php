<?php

namespace App\Http\Middleware;

use Closure;

class ManagePermissions
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
        if (in_array('User Permission Write', $user->permissions)) {
            return $next($request);
        }

        return redirect()->route;
    }
}
