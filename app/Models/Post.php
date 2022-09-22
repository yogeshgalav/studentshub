<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function classroom(){
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function postmedia(){
        return $this->hasMany(PostMedia::class, 'post_id');
    }
}
