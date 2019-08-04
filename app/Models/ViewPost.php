<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewPost extends Model
{
    protected $appends=['post'];
    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }
}
