<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    //
    public function index(Request $request)
    {

        $feedbacks = DB::table('feedbacks as fe')
        ->leftJoin('users as us','us.id','=','fe.user_id')
        ->select('fe.description','fe.created_at','fe.email','us.full_name')
        ->get();

        return response()->json([
            'success'=>[
                'feedbacks'=>$feedbacks,
            ]
        ]);
    }
}
