<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultipleChoice extends Model
{
    //
    protected $guarded = [
        'id','created_at','updated_at'
    ];

    public function getIsCorrectAttribute($value){
        return $value ? true : false;
    }
}
