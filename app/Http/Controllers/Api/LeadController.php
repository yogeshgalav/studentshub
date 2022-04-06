<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadAssigned;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DB;

class LeadController extends Controller
{
    //
    public function index(User $user, Request $request){
       
        $leads = User::doesntHave('lead')->get();
        return response()->json([
            'success'=>['leads'=>$leads],
        ]);
    }

    public function createOrUpdate($user_id, Request $request){

            //find lead via user_id
            //if lead is not present create new
            //save request data for new or old lead
            $lead=Lead::where('user_id',$user_id)->first();
            if(empty($lead)){
                $lead = new Lead();
                $lead->user_id = $user_id;
            }
                $lead->lead_status = $request->lead_status;
                $lead->description = $request->description;
                $lead->save();
                $la=new LeadAssigned;
                $la->lead_id = $lead->id;
                $la->staff_user_id = $request->user('api')->id;
                $la->save();
                return response()->json([
                    'success'=>[
                        'lead'=>$lead
                    ],
                ]);
            
    }
}