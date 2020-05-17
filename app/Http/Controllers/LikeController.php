<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Auth;

class LikeController extends Controller
{
    //
    public function post(Request $request){
        $post=Post::findOrFail($request->post_id);
        $like=Like::where($post->id,'=','likable_id')->where('li.likable_type','=','App\Models\Post')->where('user_id','=',Auth::user()->id)->first();
        switch($request->input('method')){
            case 'add':
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
        return response()->json('success');
    }
}
