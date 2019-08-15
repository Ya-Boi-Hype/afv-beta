<?php

namespace App\Http\Middleware;

use Closure;

class ManageApprovals
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
        if (in_array("User Enable Write", $user->permissions) || $user->admin) {
            return $next($request);
        }

        return redirect(route('home'));
    }
}
