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
        if($user && $user->must_reset_password && !in_array($request->path(),['reset-password','login','get-started','logout'])){
            return redirect('/reset-password');
        }
        if($user && !$user->onboarded_at && !in_array($request->path(),['reset-password','login','get-started','check-in','logout','seeker'])){
            return redirect('/check-in');
        }
        return $next($request);
        
    }
}
