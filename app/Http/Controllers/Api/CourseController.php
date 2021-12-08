<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use DB;

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
            'subjects'=>$course->subjects()->get(),
        ]]);
    }

    public function index(Request $request)
    {
        $course_query = DB::table('courses as cor');
        if(!empty($request->searchTerm)){
            $search = str_replace('.', '', $request->searchTerm);

            $course_query = $course_query->where('cor.course_name', 'LIKE', '%' . $search . '%')
            ->orWhere('cor.alias', 'LIKE', '%' . $search . '%');
        }
        $courses = $course_query->leftJoin('users as us', 'cor.id', '=', 'us.preferred_course_id')
            ->select('cor.id', 'cor.course_name', 'cor.category_id', 'cor.slug',
             DB::raw("COUNT('us.id') as totalStudent"))
            ->groupBy('cor.id', 'cor.course_name', 'cor.category_id', 'cor.slug')
            ->orderBy('totalStudent', 'DESC')->limit(10)->get();

        // if(count($courses)==0 && empty($request->aliasSearch)){
        //     $request->request->add(['aliasSearch'=>true]);
        //     $new_terms=str_split(str_replace('.', '', $request->searchTerm));
        //     $request->searchTerm=implode('%',$new_terms);
        //     return $this->courseList($request);
        // }

        // if (count($courses) == 0 && empty($request->recursive)) {
        //     $request->request->add(['recursive' => true]);
        //     $terms = explode(' ', $request->searchTerm);
        //     $new_terms = [];
        //     foreach ($terms as $term) {
        //         $new_terms[] = substr($term, 0, 1) . '%' . substr($term, -1);
        //     }
        //     $request->searchTerm = implode(' ', $new_terms);
        //     return $this->courseList($request);
        // }

        return response()->json(['success' => [
            'courses' => $courses
        ]]);
    }  
}
