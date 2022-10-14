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
        $institutes = DB::table('institutes as in');
        if(!empty($request->searchTerm)){
            $search = str_replace('.', '', $request->searchTerm);
            $institutes = $institutes->where('in.name', 'LIKE', '%' . $search . '%')
            ->limit(10)->get();
        }

        return response()->json(['success'=>[
            'institutes'=>$institutes
          ]]);
    }
}