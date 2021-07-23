<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateClassroomDetailsRequest;
use App\Models\Classroom;
use App\Models\Unit;
use App\Models\ClassroomUser;
use App\Http\Requests\CreateClassroomRequest;
use DB;
use Auth;
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

        $subject= \App\Models\Subject::getOrCreate(null, $request->subject_name, $course->category_id, true);

        \App\Models\CourseSubject::firstOrCreate([
            'subject_id'=>$subject->id,
            'course_id'=>$course->id,
        ]);
        
        $classroom=new Classroom;
        $classroom->name=$request->classroom_name;
        $classroom->teacher_user_id=Auth::id();
        $classroom->subject_id=$subject->id;
        $classroom->institute_id=$request->institute_id;
        $classroom->course_id=$course->id;
        $classroom->save();

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
                DB::raw('COUNT(classroom_messages.id) as total_messages'),
                DB::raw('FORMAT(AVG(daily_reports.marks_obtained),2) as average_score')
                )
        ->groupBy('cl.id','users.full_name','subjects.subject_name','cl.name','cl.classroom_join_id')
        ->get();

        return response()->json([
            'success'=>[
                'classrooms' => $classrooms,
                'canCreateClassroom' => $request->user('api')->isInstituteMember(),
            ]
        ]);
    }

    public function joinClassroom(Request $request){
       
        $classroom=Classroom::where('classroom_join_id',$request->name)->first();
        $student =Auth::student();
        dd($student, $classroom);
        if(empty($classroom)){
            return response()->json(['error'=>[
                'field'=>'classroom_id',
                'message'=>'This classroom join id does not exist.'
            ]],422);
        }elseif($student->course_id !== $classroom->course_id  ||  $student->institute_id !== $classroom->institute_id){
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
    public function getClassmates(){
        $classmates = DB::table('users as us')
        ->leftjoin('classroom_users as cu','cu.user_id','=','us.id')
        ->whereIn('cu.classroom_id',Auth::user()->getClassroomIds())
        ->select('us.id','us.full_name')
        ->get();
        $classmates_interests = DB('interest as intr')
        ->whereIn('interest.user_id',$classmates->id)
        ->select(DB::raw('intr.total_views + (intr.total_likes*3) + (intr.total_posts*7)'))
        ->get();
        
        return 'success';
    }
}