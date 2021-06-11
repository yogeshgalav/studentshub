<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\DailyAssignment;
use App\Models\DailyQuestion;
use App\Models\DailyAnswer;
use App\Models\DailyReport;
use App\Models\User;
use Auth;
use DB;
use Log;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DailyReportController extends Controller
{
    public function declineAttempt($daily_assignment_id){

        $report = DailyReport::create([
            'user_id'=>Auth::id(),
            'daily_assignment_id'=>$daily_assignment_id,
            'duration'=>'00:00:00',
            'rank'=>0,
            'marks_obtained'=>0,
            'status'=>'declined'
        ]);

        return true;
    }
}