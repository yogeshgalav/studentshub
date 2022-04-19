<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Chatroom;
use App\Models\Institute;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DB;

class ChatroomController extends Controller
{
    public function addchatroom(Request $request){
        $instituteId=Auth::user()->preferred_institute_id;
        $chatroom = Chatroom::create([
            'created_by_user_id'=>Auth::id(),
            'institute_id'=>$instituteId,
            'chatroom_name'=>$request->chatroom_name,
        ]);
        return response()->json(['success'=>[
            'chatroom'=> $chatroom
        ]]);
    } 
    public function chatroomDetails(Request $request){
        $chatrooms = DB::table('chatrooms as ch')
        ->where('institute_id',$request->user('api')->preferred_institute_id)
        ->leftjoin('users as us','us.id','=','ch.created_by_user_id')
        ->leftjoin('institutes as in','in.id','=','ch.institute_id')
        ->select(
            'ch.id','ch.chatroom_name','ch.institute_id','us.id as user_id','us.full_name as teacher_name', 'in.name as institute_name')
        ->groupBy('ch.id','ch.chatroom_name','ch.institute_id','us.id','us.full_name', 'in.name')
        ->get();
        
        

        return response()->json([
            'success'=>[
                'chatrooms'=>$chatrooms,
                'canCreateChatroom' => $request->user('api')->isInstituteMember(),
            ]
        ]);
    }
}