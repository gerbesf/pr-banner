<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminBanner
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

        $session = session()->get('logged');
        if(!$session){
            return redirect('/login');
        }
        return $next($request);
    }
}
