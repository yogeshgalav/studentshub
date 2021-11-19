<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class LastSeenMiddleware
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
        if (auth()->guest()) {
            return $next($request);
        }
        if (auth()->user()->last_seen_at === null || auth()->user()->last_seen_at->diffInHours(now()) !==0)
        { 
            Log::info('last seen updated for '.auth()->user()->full_name.' #'.auth()->user()->id);
            DB::table("users")
              ->where("id", auth()->user()->id)
              ->update(["last_seen_at" => now()]);
        }
        return $next($request);
    }
}
