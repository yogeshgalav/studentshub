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
    public function addChatroom(Request $request){
           
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
            ]]);
    } 
    public function updateChatroom($chatroom_id,Request $request){
       
            $chatroom = Chatroom::find($chatroom_id);
            $chatroom->name =$request->name;
            $chatroom->save();
            return response()->json(['success'=>[
                'chatroom'=> $chatroom,
            ]]);
    }
    public function chatroomDetails(Request $request){
        $user_id=Auth::id();
        $chatrooms = DB::table('chatroom_users as chus')->where('chus.user_id', $user_id)
        ->leftjoin('chatrooms as ch','ch.id','=','chus.chatroom_id')
        ->select('ch.id','ch.name','ch.uuid')
        ->groupby('ch.id','ch.name','ch.uuid')
        ->get();
    
        return response()->json([
            'success'=>[
                'chatrooms'=>$chatrooms,
               ]
        ]);
    }

    public function delete ($chatroomId)
    {
        $chatroom =DB::table('chatrooms')
        ->leftJoin('chatroom_users','chatrooms.id', '=','chatroom_users.chatroom_id')
        ->where('chatrooms.id', $chatroomId); 
        DB::table('chatroom_users')->where('chatroom_id', $chatroomId)->delete();                           
        $chatroom->delete();
        return 'success';
    }
}