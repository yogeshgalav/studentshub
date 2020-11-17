<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstituteUser extends Model
{
    //
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function institute(){
        return $this->belongsTo('App\Model\Institute');
    }

    public function user(){
        return $this->belongsTo('App\Model\User');
    }

}
