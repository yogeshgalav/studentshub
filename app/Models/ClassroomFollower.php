<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomFollower extends Model
{
    use HasFactory;
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function classroom(){
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function followerUsers(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
