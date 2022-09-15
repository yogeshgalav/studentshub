<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateClassroomDetailsRequest;
use App\Models\Classroom;
use App\Models\Unit;
use App\Models\ClassroomUser;
use App\Models\Student;
use App\Http\Requests\CreateClassroomRequest;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use Illuminate\Support\Facades\Log;

class ClassroomController extends Controller
{
    //
    

    //web endpoit to classroomm vieew for teachers
    public function getClassroomDetails($classroom_id){
        $classroomDetail = DB::table('classrooms as cs')
        ->where('cs.id',$classroom_id)
        ->join('courses as co','co.id','=','cs.course_id')
        ->join('subjects as su','su.id','=','cs.subject_id')
        ->join('users as us','us.id','=','cs.teacher_user_id')
        ->leftJoin('classroom_users as cus','cus.classroom_id','=','cs.id')
        ->select('cs.id','cs.name','cs.classroom_join_id','cs.teacher_user_id','cs.subject_id','cs.meet_link','co.course_name','cs.institute_id','cs.course_id','su.subject_name','us.id as user_id','us.full_name as teacher_name',
        DB::raw('COUNT(cus.id) as total_students'))
        ->groupBy('cs.id','cs.name','cs.classroom_join_id','cs.teacher_user_id','cs.subject_id','cs.meet_link','co.course_name','cs.institute_id','cs.course_id','su.subject_name','us.id','us.full_name')
        ->first();

        return response()->json([
            'success'=>[
                'classroomDetail'=>$classroomDetail
            ]
        ]);
    }

    public function update(Classroom $classroom, UpdateClassroomDetailsRequest $request){
        $classroom->update([
            'name'=> $request->name,
            'meet_link'=> $request->meet_link,
        ]);

        return response(['success'=>[
            'classroom'=>$classroom
        ]]);
    }
    public function delete($classroomId,Request $request){
        $classroom=Classroom::findOrFail($classroomId);
        if(ClassroomUser::where('classroom_id',$classroomId)->count()>0){
            return response('forbidden',403);    
        }
        $classroom->delete();

        return response([],204);
    }

    
    public function createClassroom(CreateClassroomRequest $request){

        $course = \App\Models\Course::find($request->course_id);
        $institute = \App\Models\Institute::firstOrCreate([
            'name'=>$request->institute_name,
        ],[
            'added_by_user_id'=>$request->user('api')->id,
        ]);
        $institute_user = \App\Models\InstituteUser::firstOrCreate([
            'institute_id'=>$institute->id,
            'user_id'=>$request->user('api')->id,
        ]);

        $subject= \App\Models\Subject::getOrCreate(null, $request->subject_name, $course->category_id, true);

        \App\Models\CourseSubject::firstOrCreate([
            'subject_id'=>$subject->id,
            'course_id'=>$course->id,
        ]);
        
        $teacher=new Teacher;
        $teacher->user_id=Auth::id();
        $teacher->institute_id=$institute->id;
        $teacher->course_id=$course->id;
        $teacher->save();

        $classroom=new Classroom;
        $classroom->name=$request->classroom_name;
        $classroom->teacher_user_id=Auth::id();
        $classroom->subject_id=$subject->id;
        $classroom->institute_id=$institute->id;
        $classroom->course_id=$course->id;
        $classroom->save();

        $me = Auth::user();
        $me->preferred_institute_id = $institute->id;
        $me->preferred_course_id= $course->id;
        $me->save();

        Log::info('New classroom created',[
            'name'=>$classroom->name,
            'user'=>Auth::id(),
            'join_id'=>$classroom->join_id]);
    
        return response()->json(['success'=>[
            'id'=>$classroom->id,
            'join_id'=>$classroom->classroom_join_id
        ]]);
    }

    public function getPreviousUnitAnswers($classroom_id){
        $answers = DB::table('classroom_answers as ca')
        ->join('descriptive_questions as cq','cq.id','=','ca.descriptive_question_id')
        ->join('units',function($join)use($classroom_id){
            $join->on('units.id','=','cq.unit_id')->where('classroom_id','=',$classroom_id)->whereNotNull('unit.deactivated');
        })
        ->select()
        ->get();

        return response()->json(['success'=>[
            'answers'=>$answers
        ]]);
    }
    public function classroomListDetails(Request $request){

        $classrooms = DB::table('classrooms as cl')
        ->whereIn('cl.id', $request->user('api')->getClassroomIds())
        ->leftjoin('classroom_users','classroom_users.classroom_id','=','cl.id')
        ->leftjoin('daily_assignments','cl.id','=','daily_assignments.classroom_id')
        ->leftjoin('users','cl.teacher_user_id','=','users.id')
        ->leftjoin('subjects','cl.subject_id','=','subjects.id')
        ->leftjoin('classroom_resources','cl.id','=','classroom_resources.classroom_id')
        ->leftjoin('messages','cl.id','=','messages.chatroom_id')
        ->leftjoin('daily_reports','daily_assignments.id','=','daily_reports.daily_assignment_id')
        ->select(DB::raw('COUNT(classroom_resources.id) as total_resources'),
                'subjects.subject_name as subject_name',
                'users.full_name AS teacher_name',
                'cl.classroom_join_id as join_id',
                'cl.id as chatroom_id',
                'cl.name as classroom_name',
                DB::raw('COUNT(distinct classroom_users.user_id) AS total_students'),
                DB::raw('COUNT(distinct daily_assignments.id) AS total_daily_assignments'),
                DB::raw('COUNT(messages.id) as total_messages'),
                DB::raw('FORMAT(AVG(daily_reports.marks_obtained),2) as average_score')
                )
        ->groupBy('cl.id','users.full_name','subjects.subject_name','cl.name','cl.classroom_join_id')
        ->get();

        return response()->json([
            'success'=>[
                'classrooms' => $classrooms,
                'canCreateClassroom' => $request->user('api')->isInstituteAdmin(),
            ]
        ]);
    }

    public function joinClassroom(Request $request)
    {
       
        $user = $request->user('api');
        $classroom=Classroom::where('classroom_join_id',$request->name)->first();
        if(empty($classroom)){
            return response()->json(['error'=>[
                'field'=>'classroom_id',
                'message'=>'This classroom join id does not exist.'
            ]],422);
        }
        
        DB::beginTransaction();
        try {      
            $user->joinClassroom($classroom);
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        // dd($e->getLine(),$e->getMessage());
        Log::critical('Join classroom failure',['data'=>$request->all(),'error'=>$e->getMessage()]);
        return response()->$e;
    }
        return response()->json(['success'=>[
            'classroom_id'=>$classroom->id,
        ]]);
    }
    public function getClassmatesDetails(){
        $categories = DB::table('categories')
        ->select('id as category_id','name as category_name')
        ->get();

        $classmates = DB::table('users as us')
        ->leftjoin('classroom_users as cu','cu.user_id','=','us.id')
        ->whereIn('cu.classroom_id',Auth::user()->getClassroomIds())
        ->select('us.id as user_id','us.full_name as user_name')
        ->groupBy('us.id','us.full_name')
        ->get()->toArray();

        $classmates_interests = DB::table('sthub_posts as sp')
        ->whereIn('sp.action_user_id',array_column($classmates,'user_id'))
        ->leftJoin('posts as po','po.id','=','sp.post_id')
        ->rightJoin('categories as ca','ca.id','=','po.category_id')
        ->leftJoin('sthub_posts as spv',function($join){
            $join->on('spv.id','=','sp.id')->where('spv.action_type','=','view');
        })
        ->leftJoin('sthub_posts as spl',function($join){
            $join->on('spl.id','=','sp.id')->where('spl.action_type','=','like');
        })
        ->leftJoin('sthub_posts as sps',function($join){
            $join->on('sps.id','=','sp.id')->where('sps.action_type','=','share');
        })
        ->select(DB::raw('count(spv.id) + count(spl.id)*3 + count(sps.id)*7 as interest_score'),
        'ca.id as category_id','ca.name as category_name','sp.action_user_id as user_id'
        )
        ->groupBy('ca.id','ca.name','sp.action_user_id')
        ->get();
        
        return response()->json(['success'=>[
            'classmates'=>$classmates,
            'classmates_interests'=>$classmates_interests,
            'categories'=>$categories,
        ]]);
    }
}