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
        return $this->belongsTo('App\Models\Post');
    }

    public static function addAction(String $action_type,Post $post,User $user)
    {
        $action_array=[0=>'view',1=>'like',2=>'comment',3=>'share'];
        $sthub_post = self::firstOrNew([
            'post_id'=>$post->id,
            'action_user_id'=>$user->id,
        ]);

        if(!$sthub_post || array_search($sthub_post->action_type,$action_array)>array_search($action_type,$action_array)) {
            return false;
        }

        $sthub_post->action_type = $action_type;
        $sthub_post->save();

        return true;
    }

}
