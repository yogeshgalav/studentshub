<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class Category extends Model
{
    use Loggable;

    public function courses(){
        return $this->hasMany('App\Models\Course');
    }
    public function subjects(){
        return $this->hasMany('App\Models\Subject');
    }
}
