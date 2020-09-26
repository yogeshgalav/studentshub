<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyQuestion extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];


    public function multipleChoice(){
        return $this->hasMany(MultipleChoice::class);
    }
    public function dailyAnswer(){
        return $this->hasMany(DailyAnswer::class);
    }
    public function myDailyAnswer(){
        return $this->hasOne(DailyAnswer::class)->where('user_id',\Auth::id());
    }
}
