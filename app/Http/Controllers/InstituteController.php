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

        $users=DB::table('institute_users as inu')->where('inu.institute_id',$instituteId)
        // ->join('institute_users as inu2',function($join){
        //     $join->on('inu2.institute_id','=','inu.institute_id')->where('inu2.user_id','=',Auth::id());
        // })
        ->join('users as us','us.id','=','inu.user_id')
        ->select('us.id','us.full_name','us.email','inu.role')
        ->get();

        return response()->json([
            'success'=>[
                'institute_detail'=>$institute_detail,
                'users'=>$users
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

    public function create(Request $request){
        $institute=Institute::create([
            'name'=>$request->form_data['client_name'],
            'added_by_user_id'=>Auth::id()
        ]);

        return response()->json(['success'=>[
            'institute_id'=>$institute->id
        ]]);
    }
}
