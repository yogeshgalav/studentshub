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
         $leads=DB::table('users')
         ->leftJoin('membership_details','membership_details.user_id','users.id')
         ->leftJoin('transaction_details','transaction_details.user_id','users.id')
         ->leftJoin('sthub_posts','sthub_posts.action_user_id','users.id')
         ->select('users.id','users.full_name', 'users.phone_no','users.is_pro_member',
                   'users.onboarded_at','users.role',
         DB::raw('COUNT(membership_details.id) as total_membership_details'),
         DB::raw('COUNT(transaction_details.id) as total_transaction_details'),
         DB::raw('COUNT(sthub_posts.id) as total_sthub_posts')
         )->groupBy('users.id','users.full_name', 'users.phone_no','users.is_pro_member','users.onboarded_at','users.role')->get();
       
         return response()->json([
            'success'=>['leads'=>$leads],
        ]);
    }

    public function createOrUpdate($userId, Request $request){

            //find lead via user_id
            //if lead is not present create new
            //save request data for new or old lead
            $lead=Lead::where('user_id',$userId)->first();
            if(empty($lead)){
                $lead = new Lead();
                $lead->user_id = $userId;
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
    public function userLead($userId){
        $leadData = DB::table('users as us')->where('us.id','=',$userId)
        ->leftJoin('leads as le', 'le.user_id','=','us.id')
        ->select('le.id as lead_id','us.id as user_id','us.full_name as user_name','le.lead_status as lead_status', 'le.description as description')->first();   
      
        $leadAssigned=DB::table('lead_assigned as lea')->where('lea.lead_id','=',$leadData->lead_id)
        ->leftjoin('users as us', 'us.id','=','lea.staff_user_id')
         ->select('us.full_name as staff_name','lea.created_at as assigned_at')->get();

         return response()->json([
             'success'=>[
                 'leadData'=>$leadData,
                 'leadAssigned'=>$leadAssigned
                ],
         ]);
    }
    
}