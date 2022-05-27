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
    public function updateOrDelete($id){
               $me=Auth::user();

        $vote=Vote::where('vote_by_id','=',$me->id)->where('subject_id','=',$id)->first();
        
        if($vote){
            $vote->delete();
        } else {
            $vote = Vote::create([
                'subject_id'=>$id,
                'vote_by_id'=>$me->id,
                'vote_status'=>1,
            ]);
            
        }
        return response()->json([], 204);
    }
}
