<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class PostView extends Model
{
    //
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public static function boot() {
        parent::boot();
        static::created(function (PostView $post_view) {
               Interest::updateOrCreate([
                'user_id'=>$post_view->user_id,
                'category_id'=>$post_view->post->category_id,
               ], [
                'total_views'=>DB::raw('total_views+1'),
               ]);
        });
    }
}
