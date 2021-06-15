<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassroomStudent;
use App\Models\ClassroomMessage;
use App\Models\ScheduledJob;
use App\Notifications\MessageAdded;
use Illuminate\Http\Request;
use App\Http\Requests\AddMessageRequest;
use App\Http\Requests\EditMessageRequest;
use Auth;
use DB;
use App\Http\Requests\JoinClassroomRequest;
use Carbon\Carbon;

class ClassroomStudentController extends Controller
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
        }elseif($student->course_id !== $classroom->course_id  ||  $student->institute_id !== $classroom->institute_id){
            return response()->json(['error'=>[
                'field'=>'classroom_id',
                'message'=>'You cannot join this classroom with your current preffered educational details.'
            ]],422);
        }
         
        ClassroomStudent::firstOrCreate([
            'student_id'=>$student->id,
            'classroom_id'=>$classroom->id
        ]);

        return response()->json('success');
    }

    public function listmessage($classroomId = null){
        $messagequery = ClassroomMessage::where('parent_message_id','=',null)
        ->leftJoin('users as us','us.id','=','classroom_messages.sender_user_id')
        ->leftJoin('classrooms as cs','cs.id','=','classroom_messages.classroom_id')
        ->leftJoin('likes as li',function($join){
            $join->on('classroom_messages.id','=','li.likable_id')->where('li.likable_type','=','App\Models\ClassroomMessage')->where('li.like_status','=',1);
        })
        // ->leftJoin('likes as uli',function($join){
        //     $join->on('classroom_messages.id','=','uli.likable_id')->where('uli.likable_type','=','App\Models\ClassroomMessage')->where('uli.user_id','=',Auth::id());
        // })
        ->select('classroom_messages.id', 'classroom_messages.sender_user_id as user_id', 'classroom_messages.classroom_id','classroom_messages.content','classroom_messages.created_at','us.full_name as user_name','us.avatar_url',
        'cs.name as classroom_name', DB::raw('COUNT(distinct li.user_id) as total_likes'));
        
        
        if($classroomId)
        {
            $messagequery = $messagequery->where('classroom_id',$classroomId);
        }else{
           
            
            $messagequery = $messagequery->whereIn('classroom_id',Auth::user()->getClassroomIds());
        }
        $messages = $messagequery->orderBy('classroom_messages.created_at','DESC')
        ->groupBy(['classroom_messages.id', 'classroom_messages.sender_user_id', 'classroom_messages.classroom_id','classroom_messages.content','classroom_messages.created_at','us.full_name','us.avatar_url','cs.name'])->get();

        foreach($messages as $message){
            $message->time = Carbon::createFromTimeStamp(strtotime($message->created_at))->diffForHumans();
        }
        return response()->json(['success'=>[
            'messages'=>$messages
        ]]);
    }
    public function addmessage(AddMessageRequest $request){
        $classroom = Classroom::findOrFail($request->classroom_id);

        $message = ClassroomMessage::create([
            'sender_user_id'=>Auth::id(),
            'classroom_id'=>$classroom->id,
            'content'=>$request->content,
            'parent_message_id'=>$request->parent_message_id,
        ]);
        ScheduledJob::newClassroomMessageNotification($classroom);
        // \Notification::send($classroom->users,new MessageAdded);

        return response()->json(['success'=>[
            'message'=>$message
        ]]);
    }
    public function replymessage($messageId){
        $messagequery = ClassroomMessage::where('parent_message_id','=',$messageId)
        ->leftJoin('users as us','us.id','=','classroom_messages.sender_user_id')
        ->leftJoin('classrooms as cs','cs.id','=','classroom_messages.classroom_id')
        ->select('classroom_messages.classroom_id', 'classroom_messages.id','classroom_messages.content','classroom_messages.created_at','us.full_name as user_name','us.avatar_url','cs.name as classroom_name');
        $messages = $messagequery->orderBy('classroom_messages.created_at','DESC')->get();

        foreach($messages as $message){
            $message->time = Carbon::createFromTimeStamp(strtotime($message->created_at))->diffForHumans();
        }
        return response()->json(['success'=>[
            'messages'=>$messages
        ]]);
    }
    public function editmessage(EditMessageRequest $request){
        
        $message=ClassroomMessage::findOrFail($request->message_id);
        if($message->sender_user_id!==Auth::id()){
            abort(401);
        }
        $message->content= $request->content;
        $message->save();


        return response()->json(['success' => ['message'=>$message]]);
    }
    public function deletemessage(Request $request){
        $classroom_message = ClassroomMessage::findOrFail($request->message_id);
        if($classroom_message->sender_user_id!==Auth::id()){
            abort(401);
        }
        ClassroomMessage::where('parent_message_id',$classroom_message->id)->delete();
        $classroom_message->delete();

        return response()->json([],204);
    }
}