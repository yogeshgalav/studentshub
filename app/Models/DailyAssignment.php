<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyAssignment extends Model
{
    //
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function dailyQuestions(){
        return $this->hasMany('App\Models\DailyQuestion');
    }
    public function dailyReport(){
        return $this->hasMany('App\Models\DailyReport');
    }
    public function unit(){
        return $this->belongsTo('App\Models\Unit');
    }
    public function isCurrentlyAvailable(){
        if($this->end_time===null){
            return true;
        }
        $current=Carbon::now(Auth::user()->timezone)->toTimeString();
        if($carbon->gt($this->start_time) && $carbon->lt($this->end_time)){
            return true;
        }
        return false;
    }

}
