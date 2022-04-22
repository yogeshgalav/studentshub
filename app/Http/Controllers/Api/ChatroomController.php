<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Chatroom;
use App\Models\ChatroomUser;
use App\Models\Institute;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Str;

class ChatroomController extends Controller
{
    public function addchatroom(Request $request){

        $chatroom =new Chatroom;
        $chatroom->uuid =Str::uuid();
        $chatroom->created_by_user_id=Auth::id();
        $chatroom->name =$request->name;
        $chatroom->save();
        $chatroomUser =new ChatroomUser;
        $chatroomUser->chatroom_id= $chatroom->id;
        $chatroomUser->user_id= $chatroom->created_by_user_id;
        $chatroomUser->joined_at =now();
        $chatroomUser->save();
        return response()->json(['success'=>[
            'chatroom'=> $chatroom,
            'chatroom'=> $chatroomUser
        ]]);
    } 
    public function chatroomDetails(Request $request){
        $chatrooms = DB::table('chatrooms as ch')
         ->leftjoin('users as us','us.id','=','ch.created_by_user_id')
         ->rightjoin('chatroom_users as chus','chus.chatroom_id','=','ch.id')
       ->select('ch.id','ch.name','us.id as user_id','ch.uuid','chus.chatroom_id')
       ->get();

        return response()->json([
            'success'=>[
                'chatrooms'=>$chatrooms,
               ]
        ]);
    }
}