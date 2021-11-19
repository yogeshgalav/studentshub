<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Like extends Model
{
    //
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    public function likable()
    {
        return $this->morphTo();
    }
    public function getLikableTypeString()
    {
        switch($this->likable_type){
            case Post::class:
                return 'post';
            case Doubt::class:
                return 'doubt';
            case ClassroomMessage::class:
                return 'message';
            case ClassroomResource::class:
                return 'resource';
        }
        return '';
    }
    // public static function boot() {
    //     parent::boot();
    //     static::created(function (Like $like) {
    //         if(Post::class===$like->likable_type){
    //            Interest::updateOrCreate([
    //             'user_id'=>$like->user_id,
    //             'category_id'=>$like->likable->category_id,
    //            ], [
    //             'total_likes'=>DB::raw('total_likes+1'),
    //            ]);
    //         }
    //     });
    // }
}
