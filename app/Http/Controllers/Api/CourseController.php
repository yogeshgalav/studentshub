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
        $search = str_replace('.', '', $request->searchTerm);
        $courses = DB::table('courses as co')
            ->where('co.name', 'LIKE', '%' . $search . '%')
            ->orWhere('so.alias', 'LIKE', '%' . $search . '%')
            ->limit(10)->get();

        return response()->json(['success'=>[
            'courses'=>$courses
          ]]);
    }
}