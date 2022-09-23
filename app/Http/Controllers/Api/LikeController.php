<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

    public function create(Request $request){

        $like=Like::where('likable_id','=',$likable->id)->where('user_id','=',Auth::user()->id)->first();

        if($like){
            $like->delete();
        }else{
            $like=new Like;
            $like->user_id = Auth::user()->id;
            $like->post_id = $request->post_id;
            $like->save();
        }

        return response()->json(['success'=>[
            'message'=>'Liked Successfully Post',
          ]]);

    }

    public function delete(Request $request){

        $like = $request->id;
        $like->delete();
        return response()->json(['success'=>[
            'message'=>'Like Successfully deleted'
          ]]);

    }

}