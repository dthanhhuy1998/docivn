<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(session()->has('userLogin')) {
            //return redirect()->route('catalog.homepage');
        } else {
            return redirect()->route('catalog.homepage');
        }

        return $next($request);
    }
}
