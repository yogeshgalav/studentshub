<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Follower;
use App\Models\UserProfile;
use Auth;
use DB;



class FollCon extends Controller
{
    public function addfollow($type,$id)
    {
        $me=Auth::user();
        $followable=Follwer::findOrFail($id);
        $follow_type=Follower::class;

        $follow=Follower::where('follower_id','=',$followable->id)->where('follow_type','=', $followable_type)->where('user_id','=',$me->id)->first();
        if($follow){
            $follow->delete();
            if($follow_type===Follower::class){
                \App\Models\Follower::deleteAction('follow',$followable,$me);
            }
        } else 
        {
            $follow = Follower::create([
                'follower_id'=>$followable->id,
                'following_id'=>$me->id,
                
            ]);
            if($followable_type===Follower::class){
                \App\Models\Follower::addAction('follow',$followable,$me);
            }
            
         
             }
}
}