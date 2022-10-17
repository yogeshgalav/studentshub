<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}