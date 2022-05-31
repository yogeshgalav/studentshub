<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Subject;
use App\Models\ScheduledJob;
use Auth;

class VoteController extends Controller
{
    public function updateOrDelete($subject_id, Request $request){

        $me_id = $request->user('api')->id;
        $vote = Vote::where('subject_id', $subject_id)->where('user_id', $me_id)->first();
        if($vote && $vote->status===$request->status){
            $vote->delete();
            return response()->json([],204);
        }
        if(!$vote){
            Vote::create([
                'subject_id'=> $subject_id,
                'user_id'=> $me_id,
                'status'=> $request->status==='upvote' ? 1 : 0
            ]);
        }else{
            $vote->status = $request->status==='upvote' ? 1 : 0;
            $vote->save();
        }

        return response()->json([], 204);
    }
}
