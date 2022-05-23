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
    public function updateOrDelete($type, $id){
        $me=Auth::user();
       
                $votable=Subject::findOrFail($id);
                $votable_type=Subject::class;
               
        
        $vote=Subject::where('votable_id','=',$votable->id)->where('votable_type','=', $votable_type)->where('user_id','=',$me->id)->first();
        if($vote){
            $vote->delete();
        } else {
            $vote = Subject::create([
                'votable_id'=>$votable->id,
                'votable_type'=>$votable_type,
                'user_id'=>$me->id,
                'vote_status'=>1,
            ]);
            ScheduledJob::NewVoteNotification($vote, $votable->user->id);
        }
        return response()->json([], 204);
    }
}
