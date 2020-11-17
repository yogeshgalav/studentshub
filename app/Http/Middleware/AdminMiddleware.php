<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\Admin;

class AdminMiddleware
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
        
        if($user && $admin=Admin::where('user_id',$user->id)->first()){
            if('Admin1'===$admin->password){
                return $next($request);
            }
        }

        abort(404);
        
    }
}
