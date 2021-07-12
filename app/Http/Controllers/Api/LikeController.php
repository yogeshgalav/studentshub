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
        switch($type)
        {
            case 'post':
                $likable_id=\App\Models\Post::findOrFail($request->likable_id)->id;
                $likable_type='App\Models\Post';
                break;
            
            case 'doubt':
                $likable_id=\App\Models\Doubt::findOrFail($request->likable_id)->id;
                $likable_type='App\Models\Doubt';
                break;
            
            case 'resource':
                $likable_id=\App\Models\ClassroomResource::findOrFail($request->likable_id)->id;
                $likable_type='App\Models\ClassroomResource';
                break;
            
            case 'message':
                $likable_id=\App\Models\ClassroomMessage::findOrFail($request->likable_id)->id;
                $likable_type='App\Models\ClassroomMessage';
        }
        $me=Auth::user();
        $like=Like::where('likable_id','=',$likable_id)->where('likable_type','=', $likable_type)->where('user_id','=',$me->id)->first();
        if($like){
            $like->delete();
        } else {
            Like::create([
                'likable_id'=>$likable_id,
                'likable_type'=>$likable_type,
                'user_id'=>$me->id,
                'like_status'=>1,
            ]);
        }
        return response()->json([], 204);
    }
}
