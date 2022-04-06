<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SubjectController extends Controller
{
    //

    public function index(Request $request)
    {
        $subject_query = DB::table('subjects as sub');
        if(!empty($request->searchTerm)){
            $search = str_replace('.', '', $request->searchTerm);
            $subject_query = $subject_query->where('sub.subject_name', 'LIKE', '%' . $search . '%')
            ->orWhere('sub.alias', 'LIKE', $search);
        }
        $subjects=$subject_query->select('sub.subject_name')
            ->groupBy('sub.subject_name')
            ->limit(10)->get();


        return response()->json(['success' => [
            'subjects' => $subjects
        ]]);
    }

    public function show(Request $request){
        $subject=\App\Models\Subject::where('slug', $request->route('id'))->firstOrFail();

        return response()->json(['success'=>[
            'subject'=>$subject,
        ]]);
      }
}
