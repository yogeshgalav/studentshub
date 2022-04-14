<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use DB;

class TransactionController extends Controller
{
    //
    public function index($userId=null){
        
        $transactionsquery=DB::table('transaction_details as tr')
        ->leftJoin('users as us','us.id','=','tr.user_id')
       ->select(['us.full_name as full_name','tr.transaction_id as transaction_id', 
                 'tr.for_plan as for_plan', 'tr.amount as amount', 'tr.tax as tax',
                'tr.discount as discount', 'tr.totalAmount as totalAmount']);
       if($userId){
           $transactions=$transactionsquery->where('us.id','=',$userId);
       }
       $transactions=$transactionsquery->get();
       return response()->json([
           'success'=>['transactions'=>$transactions],
       ]);
    }

    
}