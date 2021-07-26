<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class ClassroomMessage extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    use Loggable;

    public function sender(){
        return $this->belongsTo('App\Models\User','sender_user_id');
    }
    public function replies(){
        return $this->hasMany('App\Models\ClassroomMessage','parent_message_id');
    }
}
