<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use DB;

class MembershipController extends Controller
{
    //
    public function index($userId=null){
        
        $membersquery=DB::table('membership_details as me')
        ->leftJoin('users as us','us.id','=','me.user_id')
       ->select(['us.full_name as full_name','me.current_plan as current_plan',
       'me.first_purchase_at','me.last_purchase_at','me.expires_at']);
     
       if($userId){
        $members=$membersquery->where('me.user_id','=',$userId);
         }
       $members=$membersquery->get();
        return response()->json([
            'success'=>['members'=>$members],
        ]);
    }
}