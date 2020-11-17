<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class SthubPost extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    protected $with=['post'];
    
    public function post()
    {
        return $this->belongsTo('App\Models\Post')->with(['postable','subject','tags']);
    }

}
