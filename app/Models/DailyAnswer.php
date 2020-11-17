<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyAnswer extends Model
{
    //
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function dailyReport(){
        return $this->belongsTo('App\Models\DailyReport');
    }
    public function dailyQuestion(){
        return $this->belongsTo('App\Models\DailyQuestion');
    }
}
