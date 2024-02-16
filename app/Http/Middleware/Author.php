<?php

namespace App\Http\Middleware;

use Closure;
use Auth; //at the top
class Author
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
        if (Auth::check() && Auth::user()->role == 'author') {
            return $next($request);
        }
        elseif (Auth::check() && Auth::user()->role == 'manager') {
            return redirect('/pm');
        }
        elseif (Auth::check() && Auth::user()->role == 'vendor') {
            return redirect('/ve');
        }
        elseif (Auth::check() && Auth::user()->role == 'admin') {
            return redirect('/ad');
        }
        else {
            return redirect('/login');
        }
    }

}
