<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

     //useri koji imaju rolu vecu ili jednaku 10 ce dobiti trazenu stranicu
    public function handle($request, Closure $next)
    {
        $user=$request->user();
        if(!isset($user->role) or $user->role<10)
        {
            return redirect('/login');
        }
        return $next($request);
    }
}
