<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Homework;
use App\Models\UserHomework;
use Carbon\Carbon;
use Auth;
use App\Models\Classroom;
use App\Models\Unit;
use DB;

class HomeworkController extends Controller
{

    public function create(Classroom $classroom, Request $request){
        $this->authorize('createHomework', $classroom);

        $homework = Homework::create([
            'submission_date'=>$request->submission_date,
            'classroom_id'=>$classroom->id,
            'teacher_user_id'=>$request->user('api')->id,
            'homework_html'=>$request->homework_html,
            'homework_text'=>$request->homework_text,
            'unit_id'=>$request->unit_id,
        ]);
        return response()->json(['success'=>[
            'homework_id'=>$homework->id,
        ]]);
    }

    public function markAsDone(Homework $homework, Request $request){
        $this->authorize('markAsDone', $homework);

        $user_homework = UserHomework::firstOrNew([
            'homework_id'=>$homework->id,
            'user_id'=>$request->user('api')->id,
        ]);
        if($user_homework->id){
            $user_homework->delete();
        }else{
            $user_homework->save();
        }
        return response()->json([], 204);
    }

    public function index(Classroom $classroom, Request $request){
        $unitList=Unit::where('classroom_id', $classroom->id)->get();
        $homeworks = DB::table('homeworks as ho')->where('ho.classroom_id',$classroom->id)
        ->join('classrooms as cl','cl.id','=','ho.classroom_id')
        ->join('users as us','us.id','=','ho.teacher_user_id')
        ->leftJoin('user_homework as uh','uh.homework_id','=','ho.id')
        ->leftJoin('user_homework as mh',function($join){
            return $join->on('mh.homework_id','=','ho.id')->where('mh.user_id','=',Auth::id());
        })
        ->leftJoin('homework_images as hi','hi.homework_id','=','ho.id')
        ->select('ho.id', 'ho.submission_date', 'ho.homework_text', 'us.full_name as teacher_name', 'us.avatar_url as teacher_avatar', 'ho.created_at',
        'mh.id as user_mark','cl.name as classroom_name',DB::raw("COUNT(Distinct 'uh.id') as total_done"))
        ->groupBy('ho.id', 'ho.submission_date', 'ho.homework_text', 'us.full_name','us.avatar_url','ho.created_at', 'mh.id','cl.name')
        ->get();

       return response()->json(['success'=>[
            'unitList'=> $unitList,
            'homeworks'=> $homeworks,
        ]]); 
    }

    public function show(Classroom $classroom, Homework $homework){
        $homework = DB::table('homeworks as ho')->where('ho.id',$homework->id)
        ->join('users as us','us.id','=','ho.teacher_user_id')
        ->leftJoin('user_homework as uh','uh.homework_id','=','ho.id')
        ->leftJoin('homework_images as hi','hi.homework_id','=','ho.id')
        ->select('ho.id', 'ho.submission_date', 'ho.homework_html', 'us.full_name',
        DB::raw("COUNT(Distinct 'uh.id') as total_done"))
        ->groupBy('ho.id', 'ho.submission_date', 'ho.homework_html', 'us.full_name')
        ->first();

        $user_homeworks = DB::table('classrooms as cl')->where('cl.id',$classroom->id)
        ->rightJoin('classroom_users as cu','cu.classroom_id','=','cl.id')
        ->rightJoin('users as us','us.id','=','cu.user_id')
        ->leftJoin('students as st', function($join)use($classroom){
            $join->on('st.id','=','st.user_id')->where('st.institute_id','=',$classroom->institute_id);
        })
        ->leftJoin('user_homework as uh','uh.user_id','=','us.id')
        ->select('us.full_name','uh.created_at as marked_done_at','st.unique_college_id as reg_no')
        ->orderBy('uh.created_at')
        ->get();

       return response()->json(['success'=>[
           'user_homeworks'=> $user_homeworks,
           'homework'=> $homework,
       ]]); 
    }

}
