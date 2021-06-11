<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use Auth;
use DB;

class UserController extends Controller
{
    //
    public function getProfile(){
        $user=Auth::user();
        $post = new \App\Post;

        $categories=DB::table('categories as cat')
        ->leftJoin('posts as po','po.category_id','=','cat.id')
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
            $category->percent=$total>0 ? (($category->total/$total)*100) : 0;
        }
        return response()->json(['success'=>[
            'interests'=>$categories,
            'posts'=>\Sthub::convert_from_latin1_to_utf8_recursively($post->getUserPosts($user->id))
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
        if($request->intro){
            $profile->introduction=$request->intro;
        }
        if($request->fb_url){
            $profile->fb_url=$request->fb_url;
        }
        if($request->insta_url){
            $profile->insta_url=$request->insta_url;
        }
        if($request->linked_url){
            $profile->linkedin_url=$request->linked_url;
        }

        $profile->save();

        if($request->full_name){
            $me->full_name=$request->full_name;
            $me->save();
        }

        return response()->json(['success'=>[
            'profile'=>$profile
        ]]);
    }
}