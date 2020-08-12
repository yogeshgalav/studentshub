<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyQuestion extends Model
{
    //

    public function multipleChoice(){
        return $this->hasMany('App\Models\MultipleChoice');
    }
}
