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
        $like=Like::where('likable_id','=',$likable_id)->where('likable_type','=',                $likable_type)->where('user_id','=',$me->id)->first();
        switch($request->input('method')){
            case 'add':
                if(is_null($like)){
                    $like= new Like();
                    $like->likable_type=$likable_type;
                    $like->likable_id=$likable_id;
                    $like->user_id=$me->id;
                }
                switch($request->input('type')){
                    case 'like':
                        $like->like_status=1;
                        $like->save();
                    break;        
                    case 'dislike':
                        $like->like_status=0;
                        $like->save();
                    break;
                }
            break;
            
            case 'delete':
            if(!is_null($like)){
                $like->delete();
            }else{
                abort(403);
            }
            break;
            
        }
        return response()->json(['success'=>[
            'user_like'=> $request->input('method') === 'add' ? $like->like_status : null,
        ]]);
    }
}
