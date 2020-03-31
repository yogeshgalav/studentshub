<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Auth;

class LikeController extends Controller
{
    //
    public function index($post_id,Request $request){
            $like=Like::where('post_id','=',$post_id)->where('user_id','=',Auth::user()->id)->first();
            switch($request->input('method')){
                case 'add':
                    switch($request->input('type')){
                        case 'like':
                            $like->like=1;
                            $like->save();
                        break;        
                        case 'dislike':
                            $like->like=0;
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
