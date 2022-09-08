<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Followers;
use App\Models\UserProfile;
use Auth;
use DB;



class FollowersController extends Controller
{
    public function updateOrDelete($id)
    {
        $me_id=Auth::user()->id; 
       // $followable=Follow::findOrFail($id);
        $follow=Followers::where('follower_user_id','=',$me_id)->where('user_id','=',$id)->first();
        if($follow){
            $follow->delete();
           
        } else 
        {
            $follow = Followers::create([
                'follower_user_id'=>$me_id,
                'user_id'=>$id,
            ]);   
           }
           return response()->json([], 204);
}
}