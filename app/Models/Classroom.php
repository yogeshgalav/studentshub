<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function teacher(){
        return $this->belongsTo('App\Models\Teacher');
    }
}
