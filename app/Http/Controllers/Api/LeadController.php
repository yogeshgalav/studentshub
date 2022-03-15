<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use DB;

class LeadController extends Controller
{
    //
    public function index(){
        
        $leads = DB::table('users')
        ->select('users.id as user_id','full_name','phone_no','onboarded_at')
        ->rightJoin('leads', function($join){
            $join->on('leads.user_id', '=', 'users.id')->where('lead_status','raw');
        })->get();
        
        return response()->json([
            'success'=>['leads'=>$leads],
        ]);
    }
}