<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

class DailyQuestionController extends Controller
{
    //
    //api end point for getting daily assisment data for students and teachers
    public function getDailyAssismentDetails(Request $request){
        $unitList=Unit::where('classroom_id',$request->classroomId)
        ->with('dailyQuestions')
        ->get();

        $dailyData=[];
        foreach($unitList as $unit){
            foreach($unit->dailyQuestions as $question){
                $date = $question->attempt_date;
                $key = array_search($date, array_column($dailyData, 'attempt_date'));
                if(!$key){
                    $dailyData[$key]=[
                        'attempt_date'=>$date,
                        'unit_no'=>$unit->unit_no,
                        'questions'=>[],
                    ];
                }
                array_push($dailyData[$key]['questions'],$question);
            }   
        }

        return response()->json([
            'success'=>[
                'unitList'=>$unitList,
                'dailyData'=>$dailyData
            ]
        ]);
    }   
}
