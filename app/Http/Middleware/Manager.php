<?php

namespace App\Http\Middleware;
use Auth; //at the top
use Closure;

class Manager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 'manager') {
            return $next($request);
        }
        elseif (Auth::check() && Auth::user()->role == 'vendor') {
            return redirect('/ve');
        }
        elseif (Auth::check() && Auth::user()->role == 'admin') {
            return redirect('/ad');
        }
        elseif (Auth::check() && Auth::user()->role == 'author') {
            return redirect('/au');
        }
        else {
            return redirect('/login');
        }
    }
}
