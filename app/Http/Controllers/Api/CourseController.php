<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Facades\Sthub;
use DB;

class CourseController extends Controller
{
    public function index(Request $request){
        $search = str_replace('.', '', $request->searchTerm);
        $courses = DB::table('courses as co')
            ->select('id','name')
            ->where('co.name', 'LIKE', '%' . $search . '%')
            ->orWhere('co.alias', 'LIKE', '%' . $search . '%')
            ->limit(10)->get();

        return response()->json(['success'=>[
            'courses'=>$courses
          ]]);
    }

    public function create(Request $request){
        $course=new Course;
        $course->name = $request->name;
        $course->slug = $request->slug;
        $course->alias = Sthub::generateAlias($request->alias);
        $course->category_id = $request->category_id;
        $course->save();

        return response()->json(['success'=>[
            'message'=>'Course Successfully Created'
          ]]);

    }
}