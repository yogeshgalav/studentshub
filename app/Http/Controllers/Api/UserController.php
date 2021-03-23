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

        return response()->json(['success'=>[
            'profile'=>$profile
        ]]);
    }

    public function resetPassword(Request $request){
        $token = $request->token;
        return view('guest.auth.reset-password')
        ->with('token',$token);
    }

    public function searchUser(Request $request){
        $users = DB::table('users as us')->where('us.full_name', 'LIKE', $request->searchTerm.'%')
            ->leftJoin('students as st', 'st.user_id', '=', 'us.id')
            ->leftJoin('batches as pbt', 'pbt.id', '=', 'st.prefferred_batch')
            ->leftJoin('institutes as inst', 'inst.id', '=', 'pbt.institute_id')
            ->leftJoin('courses', 'courses.id', '=', 'pbt.course_id')
            ->leftJoin('teachers as th', 'th.id', '=', 'th.user_id')
            ->leftJoin('institutes as inst2', 'inst2.id', '=', 'th.institute_id')
            ->select(
                'inst.id as instituteId',
                'inst.name as instituteName',
                'courses.id as courseId',
                'courses.course_name as courseName',
                'courses.course_url as courseUrl',
                'pbt.id as batchId',
                'pbt.start_year as start_year',
                'pbt.end_year as end_year',
                'st.prefferred_batch as preferred_batch',
                'st.prefferred_category as preferred_category',
                'inst2.id as instituteId',
                'inst2.name as instituteName',
                'th.id as id', 'th.user_id'
            )->limit(10)->get();

            return response()->json([
                'success'=>[
                    'users'=>$users,
                ]
            ]);
    }
}
