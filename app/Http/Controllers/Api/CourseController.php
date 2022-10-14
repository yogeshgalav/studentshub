<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class CourseController extends Controller
{
    public function index(Request $request){
        $courses = DB::table('courses as co');
        if(!empty($request->searchTerm)){
            $search = str_replace('.', '', $request->searchTerm);
            $courses = $courses->where('co.name', 'LIKE', '%' . $search . '%')
            ->limit(10)->get();
        }

        return response()->json(['success'=>[
            'courses'=>$courses
          ]]);
    }
}