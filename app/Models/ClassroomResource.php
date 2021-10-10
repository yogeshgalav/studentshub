<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class ClassroomResource extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    use Loggable;

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function classroom(){
        return $this->belongsTo('App\Models\Classroom');
    }
}
