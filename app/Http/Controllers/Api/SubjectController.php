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
        $subjects = DB::table('subjects as sub');
        if(!empty($request->searchTerm)){
            $search = str_replace('.', '', $request->searchTerm);
            $subjects = $subjects->where('sub.name', 'LIKE', '%' . $search . '%')
            ->limit(10)->get();
        }

        return response()->json(['success'=>[
            'subjects'=>$subjects
          ]]);
    }
}