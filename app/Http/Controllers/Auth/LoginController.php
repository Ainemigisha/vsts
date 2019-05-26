<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/public';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'name';
    }
    
    protected function redirectTo( ) {
        return redirect('/bus_admin');
        /*
        return redirect('/bus_admin');
        if (Auth::check() && Auth::user()->category == 'police') {
            return redirect('/police_admin');
        }elseif (Auth::check() && Auth::user()->category == 'bus_admin') {
            return redirect('/bus_admin');
        }elseif (Auth::check() && Auth::user()->category == 'system_admin') {
            return redirect('/system_admin');
        }elseif (Auth::check() && Auth::user()->category == 'public') {
            return redirect('/public');
        }else{
            return route('home');
        }*/
        
    }
}
