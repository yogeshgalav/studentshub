<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class DailyAssignment extends Model
{
    //
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function dailyQuestions(){
        return $this->hasMany('App\Models\DailyQuestion');
    }
    public function dailyReports(){
        return $this->hasMany('App\Models\DailyReport');
    }
    public function unit(){
        return $this->belongsTo('App\Models\Unit');
    }
    public function classroom(){
        return $this->belongsTo('App\Models\Classroom');
    }
    public function isCurrentlyAvailable(){
        if($this->end_time===null){
            return true;
        }
        $current=Carbon::now(Auth::user()->timezone);
        $start_time = Carbon::parse($this->start_time,Auth::user()->timezone);
        $end_time = Carbon::parse($this->end_time,Auth::user()->timezone);
        // dd($current,$start_time,$current->gt($start_time),$current->lt($end_time));
        if($current->gt($start_time) && $current->lt($end_time)){
            return true;
        }
        return false;
    }

}
