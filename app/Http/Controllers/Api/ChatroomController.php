<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Chatroom;
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
        $chatroom->Uuid =Str::Uuid();
        $chatroom->created_by_user_id=Auth::id();
        $chatroom->chatroom_name =$request->chatroom_name;
        $chatroom->save();

        return response()->json(['success'=>[
            'chatroom'=> $chatroom
        ]]);
    } 
    public function chatroomDetails(Request $request){
        $chatrooms = DB::table('chatrooms as ch')
         ->leftjoin('users as us','us.id','=','ch.created_by_user_id')
       ->select('ch.id','ch.chatroom_name','us.id as user_id','ch.Uuid')
       ->get();

        return response()->json([
            'success'=>[
                'chatrooms'=>$chatrooms,
               ]
        ]);
    }
}