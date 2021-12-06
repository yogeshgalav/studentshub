<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    //
    public function show(Request $request){
        $course = null;
        if ($request->route('id')){
            $course=Course::findOrFail($request->route('id'));
        }else if($request->user('api')){
            $course=Course::findOrFail($request->user('api')->preferred_course_id);
        }

        if(empty($course)){
            abort(404);
        }

        $post=new \App\Post;
        $posts = $post->getCoursePosts($course->id);

        return response()->json(['success'=>[
            'posts'=>\Sthub::convert_from_latin1_to_utf8_recursively($posts),
            'course'=>$course,
            'subject'=>$course->subjects()->get(),
        ]]);
      }
      
}
