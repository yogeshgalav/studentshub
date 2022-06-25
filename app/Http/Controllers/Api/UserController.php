<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Institute;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\SthubFile;
use Storage;
use Auth;
use DB;

class UserController extends Controller
{
    //
    public function getProfile(){
        $user=Auth::user();

        $categories=DB::table('categories as cat')->whereNull('parent_category_id')
        ->leftJoin('posts as po','po.category_id','=','cat.id')
        ->leftJoin('sthub_posts as spv',function($join){
            $join->on('spv.post_id','=','po.id')
            ->where('spv.action_type','=','view')
            ->where('spv.action_user_id','=',Auth::id());
        })
        ->leftJoin('sthub_posts as spl',function($join){
            $join->on('spl.post_id','=','po.id')
            ->where('spl.action_type','=','like')
            ->where('spl.action_user_id','=',Auth::id());
        })
        ->leftJoin('sthub_posts as spc',function($join){
            $join->on('spc.post_id','=','po.id')
            ->where('spc.action_type','=','comment')
            ->where('spc.action_user_id','=',Auth::id());
        })
        ->leftJoin('sthub_posts as sps',function($join){
            $join->on('sps.post_id','=','po.id')
            ->where('sps.action_type','=','share')
            ->where('sps.action_user_id','=',Auth::id());
        })
        ->select('cat.id','cat.name','cat.slug',
        DB::raw('COUNT(distinct spl.post_id) as total_likes'),
        DB::raw('COUNT(distinct spv.post_id) as total_views'),
        DB::raw('COUNT(distinct sps.post_id) as total_posts'))
        ->groupBy('cat.id','cat.name','cat.slug')
        ->get();

        return response()->json(['success'=>[
            'interests'=>$categories,
        ]]);
    }

    public function saveProfile(Request $request){
        $me=$request->user('api');
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
            \Storage::disk('profile-image')->put($file_name,base64_decode($image));
            $me->avatar_url="/storage/profile-images/".$file_name;
            $me->save();
            $newFile= new SthubFile();
            $newFile->fileable_id=$me->id;
            $newFile->fileable_type=User::class;
            $newFile->file_ext=Storage::disk('profile-image')->getMimeType($file_name);
            $newFile->file_size=Storage::disk('profile-image')->size($file_name);
            $newFile->file_name=$file_name;
            $newFile->user_id=$me->id;
            $newFile->save();
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
            $me->preferred_institute_id=Institute::getFirstOrCreateId($request->preferred_institute);
            $me->preferred_course_id=Course::getFirstOrCreateId($request->preferred_course);
            $me->save();
        }

        return response()->json(['success'=>[
            'profile'=>$profile
        ]]);
    }
    public function saveInstiProfile(Request $request){
        $me=$request->user('api');
        $profile=Institute::where('added_by_user_id',$me->id)->first();
        if($request->fb_url){
            $profile->fb_url=$request->fb_url;
        }
        if($request->twitter_url){
            $profile->twitter_url=$request->twitter_url;
        }
        if($request->insta_url){
            $profile->insta_url=$request->insta_url;
        }
        if($request->linkedin_url){
            $profile->linkedin_url=$request->linkedin_url;
        }
        if($request->youtube_vedio_url){
            $profile->youtube_vedio_url=$request->youtube_vedio_url;
        }
        $profile->website =$request->website;
        $profile->address =$request->address;
       
        $profile->save();
        return response()->json(['success'=>[
            'profile'=>$profile
        ]]);
    }
    public function addCourseInstitute(User $user,Request $request){
        $me = $request->user('api');
        $teacher = new Teacher();
        $teacher->user_id = $me->id;
        $teacher->course_id = Course::getFirstOrCreateId($request->edit_course);
        $teacher->institute_id = Institute::getFirstOrCreateId($request->edit_institute);
        $teacher->save();
    }
    public function deleteTeacherDetails($teacher_id){
        $teacher=Teacher::findOrFail($teacher_id);
        $teacher->delete();

        return 'success';
    }
    public function addStudentDetails(User $user,Request $request){
        $me = $request->user('api');
        $student = new Student();
        $student->user_id = $me->id;
        $student->course_id = Course::getFirstOrCreateId($request->edit_course);
        $student->institute_id = Institute::getFirstOrCreateId($request->edit_institute);
        $student->save();
    }
    public function deleteStudentDetails($student_id){
        $student=Student::findOrFail($student_id);
        $student->delete();

        return 'success';
    }

    public function setPreferredDetails(Request $request){
        $me=$request->user('api');
        if($request->preferred_course){
            $me->preferred_course_id=Course::getFirstOrCreateId($request->preferred_course);
        }
        if($request->preferred_institute){
            $me->preferred_institute_id=Institute::getFirstOrCreateId($request->preferred_institute);
        }
        $me->save();
        $me->refresh();
        
        if($me->preferred_course_id && $me->preferred_institute_id){
            if($me->role==='student'){
                Student::firstOrCreate([
                    'user_id' => $me->id,
                    'institute_id'=>$me->preferred_institute_id,
                    'course_id'=>$me->preferred_course_id,
                ]);
            }
            if($me->role==='teacher'){
                Teacher::firstOrCreate([
                    'user_id' => $me->id,
                    'institute_id'=>$me->preferred_institute_id,
                    'course_id'=>$me->preferred_course_id,
                ]);
            }
        }
        
        return response()->json([], 204);
    }

}