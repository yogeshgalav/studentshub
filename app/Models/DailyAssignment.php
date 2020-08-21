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
}
