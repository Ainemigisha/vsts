<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class BusAdminAuth
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
        if (Auth::check() && Auth::user()->category == 'bus_admin') {
            return $next($request);
        }elseif (Auth::check() && Auth::user()->category == 'police') {
            return redirect('/police_admin');
        }elseif (Auth::check() && Auth::user()->category == 'system_admin') {
            return redirect('/system_admin');
        }elseif (Auth::check() && Auth::user()->category == 'public') {
            return redirect('/public');
        }else{
            return route('login');
        }
    }
}
