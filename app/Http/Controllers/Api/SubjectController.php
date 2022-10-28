<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Facades\Sthub;
use DB;

class SubjectController extends Controller
{
    public function index(Request $request){
        $search = str_replace('.', '', $request->searchTerm);
        $subjects = DB::table('subjects as sub')
            ->select('id','name')
            ->where('sub.name', 'LIKE', '%' . $search . '%')
            ->orWhere('sub.alias', 'LIKE', '%' . $search . '%')
            ->limit(10)->get();

        return response()->json(['success'=>[
            'subjects'=>$subjects
          ]]);
    }

    public function create(Request $request){
        $subject=new Subject;
        $subject->name = $request->name;
        $subject->slug = $request->slug;
        $subject->alias = Sthub::generateAlias($request->alias);
        $subject->category_id = $request->category_id;
        $subject->save();

        return response()->json(['success'=>[
            'message'=>'Course Successfully Created'
          ]]);

    }
}