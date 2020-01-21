<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Auth;

class LikeController extends Controller
{
    //
    public function index($post_id,Request $request){
        
            switch($request->input('method')){
                case 'add':
                    switch($request->input('type')){
                        case 'like':
                        $like=Like::updateOrCreate(['post_id'=>$post_id,'user_id'=>Auth::user()->id],['like'=>1]);
                        break;        
                        case 'dislike':
                        $like=Like::updateOrCreate(['post_id'=>$post_id,'user_id'=>Auth::user()->id],['like'=>0]);
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
