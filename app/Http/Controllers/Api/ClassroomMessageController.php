<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassroomUser;
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

class ClassroomMessageController extends Controller
{

    public function listmessage($classroomId = null){
        $messagequery = ClassroomMessage::where('parent_message_id','=',null)
        ->leftJoin('users as us','us.id','=','classroom_messages.sender_user_id')
        ->leftJoin('classrooms as cs','cs.id','=','classroom_messages.classroom_id')
        ->leftJoin('likes as li',function($join){
            $join->on('classroom_messages.id','=','li.likable_id')->where('li.likable_type','=','App\Models\ClassroomMessage')->where('li.like_status','=',1);
        })
        ->leftJoin('likes as uli',function($join){
            $join->on('classroom_messages.id','=','uli.likable_id')->where('uli.likable_type','=','App\Models\ClassroomMessage')->where('uli.user_id','=',Auth::id());
        })
        ->select('classroom_messages.id', 'classroom_messages.sender_user_id as user_id', 'classroom_messages.classroom_id','classroom_messages.content','classroom_messages.created_at',
        'us.full_name as user_name','us.avatar_url','uli.like_status as user_like',
        'cs.name as classroom_name', DB::raw('COUNT(distinct li.user_id) as total_likes'));
        
        
        if ($classroomId) {
            $messagequery = $messagequery->where('classroom_id',$classroomId);
        } else {
            $messagequery = $messagequery->whereIn('classroom_id',Auth::user()->getClassroomIds());
        }
        $messages = $messagequery->orderBy('classroom_messages.created_at','DESC')
        ->groupBy([
        'classroom_messages.id', 'classroom_messages.sender_user_id', 'classroom_messages.classroom_id','classroom_messages.content','classroom_messages.created_at',
        'us.full_name','us.avatar_url','cs.name','uli.like_status'])
        ->get();

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
        // $parent_message = ClassroomMessage::find($request->parent_message_id);
        // if ($parent_message->sender_user_id != Auth::id()) {
        //     foreach ($parent_message->replies()->get() as $reply) {
        //         ScheduledJob::newClassroomReplyMessageNotification($classroom, $reply->sender()->first());
        //     }
        //     ScheduledJob::newClassroomReplyMessageNotification($classroom, $parent_message->sender()->first());
        // }
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