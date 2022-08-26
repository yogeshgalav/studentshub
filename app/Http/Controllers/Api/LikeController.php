<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;
use App\Models\Doubt;
use App\Models\ClassroomResource;
use App\Models\ChatroomMessage;
use App\Models\ScheduledJob;
use Auth;

class LikeController extends Controller
{
    //
    public function updateOrDelete($type, $id){
        $me=Auth::user();
        switch($type)
        {
            case 'post':
                $likable=Post::findOrFail($id);
                $likable_type=Post::class;
                break;
            
            case 'doubt':
                $likable=\App\Models\Doubt::findOrFail($id);
                $likable_type=Doubt::class;
                break;
            
            case 'resource':
                $likable=ClassroomResource::findOrFail($id);
                $likable_type=ClassroomResource::class;
                break;
            
            case 'message':
                $likable=ChatroomMessage::findOrFail($id);
                $likable_type=ChatroomMessage::class;
        }
        $like=Like::where('likable_id','=',$likable->id)->where('likable_type','=', $likable_type)->where('user_id','=',$me->id)->first();
        if($like){
            $like->delete();
            if($likable_type===Post::class){
                \App\Models\SthubPost::deleteAction('like',$likable,$me);
            }
        } else {
            $like = Like::create([
                'likable_id'=>$likable->id,
                'likable_type'=>$likable_type,
                'user_id'=>$me->id,
                'like_status'=>1,
            ]);
            if($likable_type===Post::class){
                \App\Models\SthubPost::addAction('like',$likable,$me);
            }
            ScheduledJob::NewLikeNotification($like, $likable->user->id);
        }
        return response()->json([], 204);
    }
}
