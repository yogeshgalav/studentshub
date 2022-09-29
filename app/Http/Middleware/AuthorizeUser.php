<?php

namespace App\Http\Middleware;

use Closure;

class AuthorizeUser
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
        if($request->user()){
            return $next($request);
        }else if($request->user('api')){
            return $next($request);
        }

        if($request->expectsJson()) {
            return response()->json('Unautorized',401);
        }

        return redirect('/');
    }
}