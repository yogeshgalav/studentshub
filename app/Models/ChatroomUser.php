<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class ChatroomUser extends Model
{
    use HasFactory;
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    use Loggable;

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
  
}
