<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassroomUser;
use App\Models\ClassroomMessage;
use App\Notifications\MessageAdded;
use Illuminate\Http\Request;
use Auth;
use DB;
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

        $pie_graph_data = DB::table('units as ut')
        ->where('ut.classroom_id',$classroom_id)
        ->leftjoin('daily_assignments as da','ut.classroom_id','=','da.classroom_id')
        ->select('ut.unit_name as label',DB::raw('COUNT(distinct da.id) as count'))
        ->groupBy('ut.id','ut.unit_name')
        ->get();
        
        $bar_data = DB::table('student_reports as sr')
        ->leftjoin('units','units.id','=','sr.unit_id')
        ->where('units.classroom_id',$classroom_id)
        ->select('sr.unit_id','sr.score_type',DB::raw('AVG(sr.score) as score'))
        ->groupBy('sr.unit_id','sr.score_type')
        ->get();
        return response()->json(['success'=>[
            'student_details'=>$student_details,
            'assignment_details'=>$assignment_details,
            'pie_graph_data'=>$pie_graph_data,
            'bar_data'=>$bar_data
        ]]);
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
            $classroomIdArray = \DB::table('classrooms')
            ->leftJoin('teachers as tc',function($join){
                $join->on('tc.id','=','classrooms.teacher_id')->where('user_id','=',Auth::id());
            })
            ->leftJoin('classroom_users as cu',function($join){
                $join->on('cu.classroom_id','=','classrooms.id')->where('cu.user_id','=',Auth::id());
            })
            ->where('tc.id','!=',null)
            ->orWhere('cu.id','!=',null)
            ->pluck('classrooms.id')
            ->toArray();
            
            $messagequery = $messagequery->whereIn('classroom_id',$classroomIdArray);
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
    public function addmessage(Request $request){
        $classroom = Classroom::findOrFail($request->classroom_id);

        $message = ClassroomMessage::create([
            'sender_user_id'=>Auth::id(),
            'classroom_id'=>$classroom->id,
            'content'=>$request->content,
            'parent_message_id'=>$request->parent_message_id,
        ]);

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
    public function editmessage(Request $request){
        
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