<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Institute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class InstituteController extends Controller
{
    public function index(Request $request){
        $search = str_replace('.', '', $request->searchTerm);
        $institutes = DB::table('institutes as in')
            ->select('id','name')
            ->where('in.name', 'LIKE', '%' . $search . '%')
            ->orWhere('in.alias', 'LIKE', '%' . $search . '%')
            ->limit(10)->get();

        return response()->json(['success'=>[
            'institutes'=>$institutes
          ]]);
    }
}