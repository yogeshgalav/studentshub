<?php

namespace App\Http\Controllers;
use App\Models\Doubt;
use App\Models\DoubtAnswer;
use Illuminate\Http\Request;
use Auth;
use Arr;
use DB;
use Illuminate\Support\Facades\Log;

class DoubtAnswersController extends Controller
{

    public function addDoubtAnswer ($doubtId,Request $request)
    {

        $input = $request->all();
        DB::beginTransaction();
    try{

        $answer = new DoubtAnswer();
        $answer->user_id = Auth::user()->id;
        $answer->doubt_id = $doubtId;
        $answer->answer = $request->answer;
        $answer->save();

    DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('Doubt Creation failure: for user id#'.Auth::user()->id.' with data '.implode(', ',Arr::flatten($input)));
            // dd($e->getMessage(),$e->getLine());
            return response()->$e;
        }
        return 'success';
    }

    public function getDoubtanswers($doubtId,Request $request)
    {
        $answers=\DB::table('doubt_answers')->where('doubt_id',$doubtId)
        ->get();

        return response()->json([
            'success'=>[
                'answerList'=>$answers
            ]
        ]);
    }

    public function getDoubtAnswersPage(){
        return view('doubt.answer');
    }
}
