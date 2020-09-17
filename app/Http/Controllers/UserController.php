<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use Auth;
use DB;

class UserController extends Controller
{
    //
    public function getInterests(){
        $user=Auth::user();
        if($user->post()->count()<4){
            return response()->json(['success'=>[
                'interests'=>[]
            ]]);
        }

        $categories=DB::table('categories as cat')->leftJoin('subjects as sub','sub.category_id','=','cat.id')
        ->leftJoin('posts as po','po.subject_id','=','sub.id')
        ->leftJoin('post_views as pv',function($join){
            $join->on('pv.post_id','=','po.id')->where('pv.user_id','=',Auth::id());
        })
        ->leftJoin('likes as li',function($join){
            $join->on('po.id','=','li.likable_id')->where('li.likable_type','=','App\Models\Post')->where('li.user_id','=',Auth::id());
        })
        ->leftJoin('posts as upo',function($join){
            $join->on('upo.subject_id','=','sub.id')->where('upo.user_id','=',Auth::id());
        })
        ->select('cat.name',DB::raw('COUNT(distinct li.likable_id) as total_likes'),DB::raw('COUNT(distinct pv.post_id) as total_views'),DB::raw('COUNT(distinct upo.id) as total_posts'))
        ->groupBy('cat.id','cat.name')
        ->get();
        
        $total=0;
        foreach($categories as $category){
            $category->total=$category->total_views+($category->total_likes*3)+($category->total_posts*7);
            $total += $category->total;
        }
        foreach($categories as $category){
            $category->percent=($category->total/$total)*100;
        }
        return response()->json(['success'=>[
            'interests'=>$categories
        ]]);
    }

    public function saveProfile(Request $request){
        $me=Auth::user();
        $profile=UserProfile::where('user_id',$me->id)->first();
        if(!$profile){
            $profile=new UserProfile();
            $profile->user_id=$me->id;
        }
        if($request->profile_pic){
            $image = $request->profile_pic; // image base64 encoded
            preg_match("/data:image\/(.*?);/",$image,$image_extension); // extract the image extension
            $image = preg_replace('/data:image\/(.*?);base64,/','',$image); // remove the type part
            $image = str_replace(' ', '+', $image);
            $file_name = 'image_' . time() . '.' . $image_extension[1]; //generating unique file name;
            $file_path="/public/profile-images/".$file_name;
            \Storage::put($file_path,base64_decode($image));
            $me->avatar_url="/storage/profile-images/".$file_name;
            $me->save();
        }
        if($request->introduction){
            $profile->introduction=$request->intro;
        }
        if($request->fb_url){
            $profile->fb_url=$request->fb_url;
        }
        if($request->insta_url){
            $profile->insta_url=$request->insta_url;
        }
        if($request->linkedin_url){
            $profile->linkedin_url=$request->linkedin_url;
        }

        $profile->save();

        return response()->json(['success'=>[
            'profile'=>$profile
        ]]);
    }

    public function resetPassword(Request $request){
        $token = $request->route('token');
        return view('guest.auth.reset-password')
        ->with('token',$token);
    }
}
