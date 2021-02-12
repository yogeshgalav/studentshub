<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Institute;

class InstituteController extends Controller
{
    //
    public function show($instituteId){
        $institute_detail = Institute::findOrFail($instituteId);

        $members=DB::table('institute_users as inu')->where('inu.institute_id',$instituteId)
        ->join('users as us','us.id','=','inu.user_id')
        ->select('us.id','us.full_name','us.email','inu.role')
        ->get();

        $teachers=DB::table('users as us')
        ->join('teachers as tch',function($join)use($instituteId){
            $join->on('us.id','=','tch.user_id')->where('tch.institute_id',$instituteId);
        })
        ->leftJoin('classrooms as cls','cls.teacher_id','=','tch.id')
        ->leftJoin('daily_assignments as da','da.classroom_id','=','cls.id')
        ->leftJoin('daily_reports as dr','dr.daily_assignment_id','=','da.id')
        ->select('us.id','us.full_name','us.email',
        DB::raw('AVG(dr.marks_obtained) as avg_score'),
        DB::raw('COUNT(distinct cls.id) as total_classrooms')
        )
        ->groupBy('us.id','us.full_name','us.email')
        ->get();

        $students=DB::table('users as us')
        ->join('students as st','us.id','=','st.user_id')
        ->join('batches as bt',function($join)use($instituteId){
            $join->on('bt.id','=','st.prefferred_batch')->where('bt.institute_id',$instituteId);
        })
        ->join('courses as cs','cs.id','=','bt.course_id')
        ->leftJoin('daily_reports as dr','dr.user_id','=','us.id')
        ->select('us.id','us.full_name','us.email','st.unique_college_id as institute_id','cs.alias as course_alias',
        DB::raw('AVG(dr.marks_obtained) as avg_score')
        )
        ->groupBy('us.id','us.full_name','us.email','st.unique_college_id','cs.alias')
        ->get();

        $classrooms=DB::table('classrooms as cls')
        ->join('teachers as tch',function($join)use($instituteId){
            $join->on('tch.id','=','cls.teacher_id')->where('tch.institute_id',$instituteId);
        })
        ->join('users as us','us.id','=','tch.user_id')
        ->leftJoin('classroom_users as cus','cus.classroom_id','=','cls.id')
        ->leftJoin('daily_assignments as da','da.classroom_id','=','cls.id')
        ->leftJoin('daily_reports as dr','dr.daily_assignment_id','=','da.id')
        ->select('cls.id','cls.name as classroom_name','us.id as teacher_user_id','us.full_name as teacher_name',
        DB::raw('Count(distinct cus.user_id) as total_students'),
        DB::raw('Count(distinct da.id) as total_assignments'),
        DB::raw('AVG(dr.marks_obtained) as avg_score')
        )
        ->groupBy('cls.id','cls.name','us.id','us.full_name')
        ->get();

        $batches = DB::table('classrooms as cls')
        ->join('batches as bt','bt.id','=','cls.batch_id')
        ->leftJoin('classroom_users as cus','cus.classroom_id','=','cls.id')
        ->leftJoin('daily_assignments as da','da.classroom_id','=','cls.id')
        ->leftJoin('daily_reports as dr','dr.daily_assignment_id','=','da.id')
        ->select('bt.id','bt.start_year','bt.end_year',
        DB::raw('Count(distinct cus.user_id) as total_students'),
        DB::raw('Count(distinct da.id) as total_assignments'),
        DB::raw('AVG(dr.marks_obtained) as avg_score')
        )
        ->groupBy('bt.id','bt.start_year','bt.end_year')
        ->get();

        return response()->json([
            'success'=>[
                'institute_detail'=>$institute_detail,
                'members'=>$members,
                'students'=>$students,
                'classrooms'=>$classrooms,
                'teachers'=>$teachers,
                'batches'=>$batches,
            ]
        ],200);
    }

    public function index(){

        $institutes=DB::table('institutes as in')
        ->leftJoin('institute_users as inu','in.id','=','inu.institute_id')
        ->leftJoin('teachers as te','te.institute_id','=','in.id')
        ->leftJoin('classrooms as cl','cl.teacher_id','=','te.id')
        ->select('in.id','in.name',
            DB::raw('COUNT(DISTINCT inu.user_id) AS user_count'),
            DB::raw('COUNT(DISTINCT te.id) AS teacher_count'),
            DB::raw('COUNT(DISTINCT cl.id) AS classroom_count')
        )
        ->groupBy(['in.id','in.name'])
        ->get();

        return response()->json([
            'success'=>[
                'institutes'=>$institutes
            ]
        ],200);
    }

    //only admin access
    public function create(Request $request){
        $institute=Institute::create([
            'name'=>$request->form_data['client_name'],
            'added_by_user_id'=>Auth::id(),
            'is_verified'=>true,
        ]);

        return response()->json(['success'=>[
            'institute_id'=>$institute->id
        ]]);
    }
}
