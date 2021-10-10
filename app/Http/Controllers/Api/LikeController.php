<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Like;
use Auth;

class LikeController extends Controller
{
    //
    public function updateOrDelete(Request $request, $type){
        $me=Auth::user();
        switch($type)
        {
            case 'post':
                $likable=\App\Models\Post::findOrFail($request->likable_id);
                $likable_type='App\Models\Post';
                \App\Models\SthubPost::addAction('like',$post,$me);
                break;
            
            case 'doubt':
                $likable=\App\Models\Doubt::findOrFail($request->likable_id);
                $likable_type='App\Models\Doubt';
                break;
            
            case 'resource':
                $likable=\App\Models\ClassroomResource::findOrFail($request->likable_id);
                $likable_type='App\Models\ClassroomResource';
                break;
            
            case 'message':
                $likable=\App\Models\ClassroomMessage::findOrFail($request->likable_id);
                $likable_type='App\Models\ClassroomMessage';
        }
        $like=Like::where('likable_id','=',$likable->id)->where('likable_type','=', $likable_type)->where('user_id','=',$me->id)->first();
        if($like){
            $like->delete();
        } else {
            $like = Like::create([
                'likable_id'=>$likable_id,
                'likable_type'=>$likable_type,
                'user_id'=>$me->id,
                'like_status'=>1,
            ]);
            // ScheduledJob::NewLikeNotification($like, $likable->user_id);
        }
        return response()->json([], 204);
    }
}
