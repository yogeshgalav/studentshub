<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DB;
use hasNot;

class LeadController extends Controller
{
    //
    public function index(User $user, Request $request){
       
        $leads = User::doesntHave('lead')->get();
        return response()->json([
            'success'=>['leads'=>$leads],
        ]);
    }

    public function create(Request $request){
       
       //we have fetch user_id from user table
       
            if ($request->route('id')){
                $lead=Lead::find($request->route('id'));
                $lead = new Lead();
                $lead->lead_status = $request->lead_status;
                $lead->description = $request->description;
                
                $lead->save();
            }else if($request->user('api')){
                $lead=Lead::find($request->user('api')->preferred_user_id);
            }
           
            return response()->json([
                'success'=>['lead'=>$lead],
            ]);
    }
}