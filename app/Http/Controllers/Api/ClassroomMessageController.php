<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\User;
use App\Models\Chatroom;
use App\Models\ClassroomUser;
use App\Models\Messages;
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
    public function listmessage($chatroomId = null, Request $request){
        $messagequery = Messages::where('parent_message_id','=',null)
        ->leftJoin('users as us','us.id','=','messages.sender_user_id')
        ->leftJoin('classrooms as cs','cs.id','=','messages.chatroom_id')
        ->leftJoin('likes as li',function($join){
            $join->on('messages.id','=','li.likable_id')->where('li.likable_type','=','App\Models\Messages')->where('li.like_status','=',1);
        })
        ->leftJoin('likes as uli',function($join){
            $join->on('messages.id','=','uli.likable_id')->where('uli.likable_type','=','App\Models\Messages')->where('uli.user_id','=',Auth::id());
        })
        ->select('messages.id', 'messages.sender_user_id as user_id', 'messages.chatroom_id','messages.content','messages.created_at',
        'us.full_name as user_name','us.avatar_url','uli.like_status as user_like',
        'cs.name as classroom_name', DB::raw('COUNT(distinct li.user_id) as total_likes'));
        
        
        if ($chatroomId) {
            $messagequery = $messagequery->where('chatroom_id',$chatroomId);
        }
        $messages = $messagequery->orderBy('messages.created_at','DESC')
        ->groupBy([
        'messages.id', 'messages.sender_user_id', 'messages.chatroom_id','messages.content','messages.created_at',
        'us.full_name','us.avatar_url','cs.name','uli.like_status'])
        ->get();

        foreach($messages as $message){
            $message->time = Carbon::createFromTimeStamp(strtotime($message->created_at))->diffForHumans();
        }
        return response()->json(['success'=>[
            'messages'=>$messages
        ]]);
    }
    public function addmessage($chatroom_id,Request $request){
        $message = Messages::create([
            'sender_user_id'=>Auth::id(),
            'chatroom_id'=>$chatroom_id,
            'content'=>$request->content,
            'parent_message_id'=>$request->parent_message_id,
        ]);
        
     //   ScheduledJob::newMessagesNotification($classroom);
        
        return response()->json(['success'=>[
            'message'=>$message
        ]]);
    }
    public function editmessage(EditMessageRequest $request){
        
        $message=Messages::findOrFail($request->message_id);
        if($message->sender_user_id!==Auth::id()){
            abort(401);
        }
        $message->content= $request->content;
        $message->save();


        return response()->json(['success' => ['message'=>$message]]);
    }
    public function deletemessage(Request $request){
        $classroom_message = Messages::findOrFail($request->message_id);
        if($classroom_message->sender_user_id!==Auth::id()){
            abort(401);
        }
        Messages::where('parent_message_id',$classroom_message->id)->delete();
        $classroom_message->delete();

        return response()->json([],204);
    }
}