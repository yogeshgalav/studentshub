<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class InsightsController extends Controller
{
    public function index(Request $request)
    {
        $days = $request->days ?? 7;
        $student = DB::table('students')
        ->where('created_at', '>', Carbon::now()->subDays($days))
        ->count();

        $registeration = DB::table('users')
        ->where('created_at', '>', Carbon::now()->subDays($days))
        ->count();

        $active_user = DB::table('users')
        ->where('last_seen_at', '>', Carbon::now()->subDays($days))
        ->count();

        $phone = DB::table('user_phones')
        ->where('created_at', '>', Carbon::now()->subDays($days))
        ->count();

        $institute = DB::table('institutes')
        ->where('created_at', '>', Carbon::now()->subDays($days))
        ->count();

        $posts = DB::table('posts')
        ->where('created_at', '>', Carbon::now()->subDays($days))
        ->count();

        $sthub_posts = DB::table('sthub_posts')
        ->where('created_at', '>', Carbon::now()->subDays($days))
        ->count();

        $doubts = DB::table('doubts')
        ->where('created_at', '>', Carbon::now()->subDays($days))
        ->count();

        return response()->json(['success' => [
             'students' => $student,
             'registeration' => $registeration,
             'active_user' => $active_user,
             'posts' => $posts,
             'sthub_posts' => $sthub_posts,
             'doubts' => $doubts,
             'phones' => $phone,
             'institutes' => $institute,
        ]]);
    }
}
