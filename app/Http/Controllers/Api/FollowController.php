<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Follow;
use App\Models\UserProfile;
use Auth;
use DB;



class FollowController extends Controller
{
    public function updateOrDelete($id)
    {
        $me_id=Auth::user()->id; 
       // $followable=Follow::findOrFail($id);
        $follow=Follow::where('followed_by_id','=',$me_id)->where('following_id','=',$id)->first();
        if($follow){
            $follow->delete();
           
        } else 
        {
            $follow = Follow::create([
                'followed_by_id'=>$me_id,
                'following_id'=>$id,
                'follow_status'=>1,
            ]);   
           }
           return response()->json([], 204);
}
}