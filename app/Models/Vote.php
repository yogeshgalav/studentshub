<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Auth;
use DB;
use Carbon\Carbon;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Vote extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    use HasSlug;

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    
    public function subjects(){
        return $this->belongsToMany(Subject::class, 'post_tags');
    }         
    
    public function likes(){
        return $this->morphMany(Like::class, 'likable');
    }
    
}
