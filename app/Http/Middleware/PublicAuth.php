<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class PublicAuth
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
        if (Auth::check() && ((Auth::user()->category == 'public') || (Auth::user()->category == 'police') || (Auth::user()->category == 'bus_admin') || (Auth::user()->category == 'system_admin') )) {
            return $next($request);
        }else{
            return route('login');
        }
    }
}
