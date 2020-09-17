<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserCheckMiddleware
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
        $user=Auth::user();  
        if($user && $user->must_reset_password && $request->path()!=='reset-password'){
            return redirect('/reset-password');
        }
        return $next($request);
        
    }
}
