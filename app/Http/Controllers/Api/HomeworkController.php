<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Homework;
use App\Models\UserHomework;
use Carbon\Carbon;
use Auth;
use DB;

class HomeworkController extends Controller
{
    //
    private $currentTime;

    public function __construct(){
        $this->currentTime = Carbon::now(request()->user('api')->timezone);
    }

    public function create(Classroom $classroom, Request $request){
        Homework::create([
            'submission_date'=>$request->submission_date,
            'classroom_id'=>$classroom->id,
            'teacher_user_id'=>$request->user('api')->id,
            'description'=>$request->description,
        ]);
        return response()->json([], 204);
    }

    public function markAsDone(Homework $homework, Request $request){
        $user_homework = UserHomework::firstOrNew([
            'homewok_id'=>$homework->id,
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
        ->join('users as us','us.id','=','ho.teacher_user_id')
        ->leftJoin('user_homework as uh','uh.homework_id','=','ho.id')
        ->leftJoin('homework_image as hi','hi.homework_id','=','ho.id')
        ->select('ho.id', 'ho.submission_date', 'ho.description', 'us.full_name',
        DB::raw("COUNT(Distinct 'uh.id') as total_done"))
        ->groupBy('ho.id', 'ho.submission_date', 'ho.description', 'us.full_name')
        ->get();

       return response()->json(['success'=>[
            'unitList'=> $unitList,
            'homeworks'=> $homeworks,
        ]]); 
    }

    public function show(Homework $homework, Request $request){
        $homework = DB::table('homeworks as ho')->where('ho.id',$homework->id)
        ->join('users as us','us.id','=','ho.teacher_user_id')
        ->leftJoin('user_homework as uh','uh.homework_id','=','ho.id')
        ->leftJoin('homework_image as hi','hi.homework_id','=','ho.id')
        ->select('ho.id', 'ho.submission_date', 'ho.description', 'us.full_name',
        DB::raw("COUNT(Distinct 'uh.id') as total_done"))
        ->groupBy('ho.id', 'ho.submission_date', 'ho.description', 'us.full_name')
        ->first();

        $user_homeworks = DB::table('homeworks as ho')->where('ho.id',$homework->id)
        ->rightJoin('classroom_users as cu','cu.clasroom_id','=','ho.classroom_id')
        ->rightJoin('users as us','us.id','=','cu.user_id')
        ->leftJoin('students as st', function($join)use($homework){
            $join->on('st.id','=','st.user_id')->where('st.institute_id','=',$homework->classroom->institute_id);
        })
        ->leftJoin('user_homework as uh','uh.user_id','=','us.id')
        ->select('ho.id', 'ho.submission_date', 'ho.description', 'us.full_name','uh.created_at as marked_done_at')
        ->orderBy('uh.created_at')
        ->get();

       return response()->json(['success'=>[
           'user_homeworks'=> $user_homeworks,
           'homework'=> $homework,
       ]]); 
    }

}
