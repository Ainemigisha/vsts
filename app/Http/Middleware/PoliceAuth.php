<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class PoliceAuth
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
        if (Auth::check() && Auth::user()->category == 'police') {
            return $next($request);
        }elseif (Auth::check() && Auth::user()->category == 'bus_admin') {
            return redirect('/bus_admin');
        }elseif (Auth::check() && Auth::user()->category == 'system_admin') {
            return redirect('/system_admin');
        }elseif (Auth::check() && Auth::user()->category == 'public') {
            return redirect('/public');
        }else{
            return route('login');
        }
    }
}
