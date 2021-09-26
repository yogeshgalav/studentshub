<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Institute;
use App\Models\User;

class InstituteController extends Controller
{
    //
    public function show($instituteId){
        $institute_detail = Institute::findOrFail($instituteId);

        $members=DB::table('institute_users as inu')->where('inu.institute_id',$instituteId)
        ->join('users as us','us.id','=','inu.user_id')
        ->select('us.id','us.full_name','us.email','inu.role')
        ->get();

        $teachers=DB::table('classrooms as cls')->where('cls.institute_id',$instituteId)
        ->leftJoin('users as us','cls.teacher_user_id','=','us.id')
        ->leftJoin('daily_assignments as da','da.classroom_id','=','cls.id')
        ->leftJoin('daily_reports as dr','dr.daily_assignment_id','=','da.id')
        ->select('us.id','us.full_name','us.email',
        DB::raw('AVG(dr.marks_obtained) as avg_score'),
        DB::raw('COUNT(distinct cls.id) as total_classrooms')
        )
        ->groupBy('us.id','us.full_name','us.email')
        ->get();

        $students=DB::table('students as st')->where('st.institute_id',$instituteId)
        ->join('users as us','us.id','=','st.user_id')
        ->join('courses as cs','cs.id','=','st.course_id')
        ->leftJoin('daily_reports as dr','dr.user_id','=','us.id')
        ->select('us.id','us.full_name','us.email','st.unique_college_id as institute_id','cs.alias as course_alias',
        DB::raw('AVG(dr.marks_obtained) as avg_score')
        )
        ->groupBy('us.id','us.full_name','us.email','st.unique_college_id','cs.alias')
        ->get();


        $classrooms = DB::table('classrooms as cl')
        ->where('cl.institute_id',$instituteId)
        ->leftjoin('classroom_users','classroom_users.classroom_id','=','cl.id')
        ->leftjoin('daily_assignments','cl.id','=','daily_assignments.classroom_id')
        ->leftjoin('users','cl.teacher_user_id','=','users.id')
        ->leftjoin('subjects','cl.subject_id','=','subjects.id')
        ->leftjoin('classroom_resources','cl.id','=','classroom_resources.classroom_id')
        ->leftjoin('classroom_messages','cl.id','=','classroom_messages.classroom_id')
        ->leftjoin('daily_reports','daily_assignments.id','=','daily_reports.daily_assignment_id')
        ->select(DB::raw('COUNT(classroom_resources.id) as total_resources'),
                'subjects.subject_name as subject_name',
                'users.full_name AS teacher_name',
                'cl.classroom_join_id as join_id',
                'cl.id as classroom_id',
                'cl.name as classroom_name',
                DB::raw('COUNT(distinct classroom_users.user_id) AS total_students'),
                DB::raw('COUNT(distinct daily_assignments.id) AS total_daily_assignments'),
                DB::raw('FORMAT(AVG(daily_reports.marks_obtained),2) as average_score')
                )
        ->groupBy('cl.id','users.full_name','subjects.subject_name','cl.name','cl.classroom_join_id')
        ->get();

        $batches = DB::table('classrooms as cl')
        ->where('cl.institute_id',$instituteId)
        ->leftjoin('classroom_users','classroom_users.classroom_id','=','cl.id')
        ->leftjoin('daily_assignments','cl.id','=','daily_assignments.classroom_id')
        ->leftjoin('daily_reports','daily_assignments.id','=','daily_reports.daily_assignment_id')
        ->select(
                'cl.name as name',
                DB::raw('COUNT(distinct cl.id) AS total_classrooms'),
                DB::raw('COUNT(distinct daily_assignments.id) AS total_daily_assignments'),
                DB::raw('FORMAT(AVG(daily_reports.marks_obtained),2) as average_score')
                )
        ->groupBy('cl.name')
        ->get();
        
        return response()->json([
            'success'=>[
                'institute_detail'=>$institute_detail,
                'members'=>$members,
                'students'=>$students,
                'classrooms'=>$classrooms,
                'batches'=>$batches,
                'teachers'=>$teachers,
            ]
        ],200);
    }

    public function index(){

        $institutes=DB::table('institutes as in')
        ->leftJoin('institute_users as inu','in.id','=','inu.institute_id')
        ->join('institute_users as insu',function($join){
            $join->on('in.id','=','insu.institute_id')
            ->where('insu.role',"teacher");
        })
        ->leftJoin('classrooms as cl','cl.institute_id','=','in.id')
        ->select('in.id','in.name',
            DB::raw('COUNT(DISTINCT inu.user_id) AS user_count'),
            DB::raw('COUNT(DISTINCT insu.id) AS teacher_count'),
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

    public function indexStudents()
    {
        $instituteId = Auth::teacher()->instituteId;
        $students=DB::table('students as st')->where('st.institute_id',$instituteId)
        ->join('users as us','us.id','=','st.user_id')
        ->join('courses as cs','cs.id','=','st.course_id')
        ->leftJoin('daily_reports as dr','dr.user_id','=','us.id')
        ->select('us.id','us.full_name','us.email','st.unique_college_id as institute_id','cs.alias as course_alias',
        DB::raw('AVG(dr.marks_obtained) as avg_score')
        )
        ->groupBy('us.id','us.full_name','us.email','st.unique_college_id','cs.alias')
        ->get();


        return response()->json(['success'=>[
            'students'=>$students,
        ]]);

    }
    public function showStudent(User $user)
    {
        $student_detail=DB::table('users as us')->where('us.id',$user->id)
        ->leftJoin('parents as pa','pa.user_id','=','us.id')
        ->leftJoin('users as pus','pus.id','=','pa.parent_user_id')
        ->select('us.full_name','us.email',
        'pus.full_name as parent_name','pus.email as parent_email','pus.phone_no as parent_phone')
        ->first();


        return response()->json(['success'=>[
            'student_detail'=>$student_detail,
        ]]);

    }
}
