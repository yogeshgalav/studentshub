<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Like;
use Auth;

class LikeController extends Controller
{
    //
    public function post(Request $request){
        $post=\App\Models\Post::findOrFail($request->post_id);
        $me=Auth::user();
        $like=Like::where('likable_id','=',$post->id)->where('likable_type','=','App\Models\Post')->where('user_id','=',$me->id)->first();
        switch($request->input('method')){
            case 'add':
                if(is_null($like)){
                    $like= new Like();
                    $like->likable_type='App\Models\Post';
                    $like->likable_id=$post->id;
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
            'user_like'=>$like ? $like->like_status : null,
        ]]);
    }
}
