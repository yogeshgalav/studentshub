<?php

namespace App\Http\Controllers;
use App\Models\Classroom;
use App\Models\ClassroomUser;
use App\Models\ClassroomMessage;
use App\Notifications\MessageAdded;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\JoinClassroomRequest;
use Carbon\Carbon;

class ClassroomUserController extends Controller
{
    //
    
    public function joinClassroom(Request $request){
       
        $classroom=Classroom::where('classroom_join_id',$request->name)->first();
        $student =Auth::student();
        if(empty($classroom)){
            return response()->json(['error'=>[
                'field'=>'classroom_id',
                'message'=>'This classroom join id does not exist.'
            ]],422);
        }elseif($student->batchId !== $classroom->batch_id){
            return response()->json(['error'=>[
                'field'=>'classroom_id',
                'message'=>'You cannot join this classroom with your current preffered educational details.'
            ]],422);
        }
         

        ClassroomUser::firstOrCreate([
            'user_id'=>Auth::id(),
            'classroom_id'=>$classroom->id
        ]);

        return response()->json('success');
    }

    public function getClassrromUserData($classroom_id){
        $student_details = \DB::table('classroom_users as csu')
        ->where('csu.classroom_id',$classroom_id)
        ->join('users','users.id','=','csu.user_id')
        ->leftJoin('students as st','st.user_id','=','users.id')
        ->select('users.id as user_id','users.full_name as user_name','st.unique_college_id')
        ->get();

        $assignment_details = \DB::table('daily_assignments as da')
        ->where('da.classroom_id',$classroom_id)
        ->rightJoin('daily_reports as dr','dr.daily_assignment_id','=','da.id')
        ->select('dr.*','da.attempt_date')
        ->orderBy('da.attempt_date')
        ->get();

        return response()->json(['success'=>[
            'student_details'=>$student_details,
            'assignment_details'=>$assignment_details
        ]]);
    }

    public function listmessage($classroomId = null){
        $messagequery = ClassroomMessage::
        leftJoin('users as us','us.id','=','classroom_messages.sender_user_id')
        ->leftJoin('classrooms as cs','cs.id','=','classroom_messages.classroom_id')
        ->select('classroom_messages.content','classroom_messages.created_at','us.full_name as user_name','us.avatar_url','cs.name as classroom_name');
        if($classroomId)
        {
            $messagequery = $messagequery->where('classroom_id',$classroomId);
        }
        $messages = $messagequery->orderBy('classroom_messages.created_at','DESC')->get();

        foreach($messages as $message){
            $message->time = Carbon::createFromTimeStamp(strtotime($message->created_at))->diffForHumans();
        }
        return response()->json(['success'=>[
            'messages'=>$messages
        ]]);
    }
    public function addmessage(Request $request, $classroomId){
        $classroom = Classroom::findOrFail($classroomId);

        $message = ClassroomMessage::create([
            'sender_user_id'=>Auth::id(),
            'classroom_id'=>$classroomId,
            'content'=>$request->content,
        ]);

        // \Notification::send($classroom->users,new MessageAdded);

        return response()->json(['success'=>[
            'message'=>$message
        ]]);
    }
    public function deletemessage(){
        $classroom_message = ClassroomMessage::findOrFail($request->message_id);
        $classroom_message->delete();

        return response()->json([],204);
    }
}
