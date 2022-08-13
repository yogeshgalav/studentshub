<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InsightsController extends Controller
{
    public function index(Request $request)
    {
        $days = $request->days ?? 7;
        $student = DB::table('students')
        ->where('created_at', '>', Carbon::now()->subDays($days))
        ->count();

        $users = DB::table('users')
        ->where('created_at', '>', Carbon::now()->subDays($days))
        ->count();

        $phone = DB::table('user_phones')
        ->where('created_at', '>', Carbon::now()->subDays($days))
        ->count();

        $institute = DB::table('institutes')
        ->where('created_at', '>', Carbon::now()->subDays($days))
        ->count();

        return response()->json(['success' => [
             'student' => $stuent,
             'users' => $users,
             'phone' => $phone,
             'institute' => $institute,
        ]]);
    }
}
