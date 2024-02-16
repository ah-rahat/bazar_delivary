<?php

namespace App\Http\Middleware;
use Auth; //at the top
use Closure;

class Admin
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
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }
        elseif (Auth::check() && Auth::user()->role == 'author') {
            return redirect('/au');
        }
        elseif (Auth::check() && Auth::user()->role == 'vendor') {
            return redirect('/ve');
        }
         elseif (Auth::check() && Auth::user()->role == 'manager') {
            return redirect('/pm');
        }
        else {
            return redirect('/login');
        }
    }
}
