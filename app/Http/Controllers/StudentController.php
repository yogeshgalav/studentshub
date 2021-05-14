<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyAssignment;
use App\Models\DailyReport;
use App\Models\DailyQuestion;
use App\Models\DailyAnswer;
use Auth;
use DB;

class StudentController extends Controller
{
    //
    public function dailyAssignmentAttemptPage($classroom_id){
        $daily_assignment=DailyAssignment::where('attempt_date','=',now(Auth::user()->timezone)->toDateString())
        ->where('activated_at','!=',null)->where('classroom_id','=',$classroom_id)
        ->with('dailyQuestions.multipleChoice')->first();
        
        // check if assignment is not already attempted
        $daily_report=null;
        if($daily_assignment){      
            $daily_assignment->dailyQuestions->makeHidden('correct_answer');      
            $daily_report = DailyReport::where('user_id',Auth::id())
            ->where('daily_assignment_id',$daily_assignment->id)->first();
        }

        if($daily_assignment && $daily_assignment->isCurrentlyAvailable() && empty($daily_report)){
            return view('student-panel.daily-attempt')
            ->with('nocache',true)
            ->with('daily_assignment',$daily_assignment);
        }
        
        return redirect('/classroom/'.$classroom_id.'/daily-assignment');
    }

    public function saveDailyAnswer(Request $request){
        $my_report = DailyReport::where('user_id',Auth::id())->where('daily_assignment_id',$request->daily_assignment_id)->exists();
        if($my_report){
            return redirect('/classroom/'.$request->classroom_id.'/daily-assignment');
        }
        $daily_questions = DailyQuestion::where('daily_assignment_id',$request->daily_assignment_id)->get();
        $rank = DailyReport::where('daily_assignment_id',$request->daily_assignment_id)->count();
        
        DB::beginTransaction();
    try{
        $total_marks = 0;
        foreach($request->answers as $answer){
            $question=$daily_questions->where('id',$answer['question_id'])->first();
            if($question->correct_answer==$answer['answer']){
                $total_marks=$total_marks+$question->marks;
            }
        }
        $unit_id = DailyAssignment::find($request->daily_assignment_id)->unit_id;
        StudentReport::firstOrCreate([
            'score_type'=> "first"
        ],[
            'user_id'=>Auth::id(),
            'unit_id'=> $unit_id,
            'score'=> $total_marks
        ]);
        StudentReport::updateOrCreate([
            'score_type' => "last"
        ],[
            'user_id'=>Auth::id(),
            'unit_id'=> $unit_id,
            'score'=> $total_marks
        ]);
        $student_avg_report = StudentReport::firstOrNew([
            'score_type' => "average",
            'user_id'=>Auth::id(),
            'unit_id'=> $unit_id
        ]);
        if($student_avg_report){
            $student_avg_report->score = ($student_avg_report->score + $total_marks) / 2;
        }
        else{
            $student_avg_report->score = $total_marks;
        }
        $student_avg_report->save();
        $report = DailyReport::create([
            'user_id'=>Auth::id(),
            'daily_assignment_id'=>$request->daily_assignment_id,
            'duration'=>'00:'.$request->time,
            'rank'=>$rank+1,
            'marks_obtained'=>$total_marks
        ]);

        foreach($request->answers as $answer){
            DailyAnswer::create([
                'user_id'=>Auth::id(),
                'daily_question_id'=>$answer['question_id'],
                'daily_report_id'=>$report->id,
                'selected_answer'=>$answer['answer'],
            ]);
        }
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        \Log::critical('daily report save failure',['data'=>$request->all(),'error'=>$e->getMessage()]);
        return response()->$e;
    }
        return redirect('/classroom/'.$request->classroom_id.'/daily-assignment');
    }
    public function sharePost()
    {
        return view('create-post.share-post');
    }
    public function editPost()
    {
        return view('student.edit-post');
    }
    public function classroomList()
    {
        return view('student.classroomList');
    }

    public function classroom()
    {
        return view('student.classroom');
    }

}
