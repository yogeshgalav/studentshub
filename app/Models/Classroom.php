<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Facades\Sthub;

class Classroom extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Sthub::ucWordSome($value);
    }

    public function teacher(){
        return $this->belongsTo('App\Models\Teacher');
    }
}
