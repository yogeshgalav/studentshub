<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use Auth;
use DB;

class LeadController extends Controller
{
    //
    public function index(Request $request){
        $leads = DB::table('users')
        ->select('users.id as user_id','full_name','phone_no','onboarded_at')
        ->rightJoin('leads', function($join){
            $join->on('leads.user_id', '=', 'users.id')->where('lead_status','raw');
        })->get();
        
        return response()->json([
            'success'=>['leads'=>$leads],
        ]);
    }

    public function create( Request $request){
       
       //we have fetch user_id from user table
            $lead = new Lead();
            $lead->lead_status = $request->lead_status;
            $lead->description = $request->description;
            
            $lead->save();
            return response()->json([
                'success'=>['lead'=>$lead],
            ]);
    }
}