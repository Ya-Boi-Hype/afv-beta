<?php

namespace App\Http\Middleware;

use Closure;

class CheckDomain
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
        $appUrl = str_replace(['http://', 'https://'], '', config('app.url'));
        if (request()->getHttpHost() != $appUrl) {
            return redirect(config('app.url').'/'.request()->path());
        }

        return $next($request);
    }
}
