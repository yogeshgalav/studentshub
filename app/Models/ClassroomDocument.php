<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassroomDocument extends Model
{
    //
    
    public function document(){
        return $this->belongsTo('App\Models\Document');
    }
}
