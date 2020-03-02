<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doubt extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function subject(){
        return $this->belongsTo('App\Models\Subject');
    }
}
