<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateClassroomDetailsRequest;
use App\Models\Classroom;
use App\Models\Batch;
use App\Models\Unit;
use App\Models\ClassroomUser;
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
        ->join('batches as bt','bt.id','=','cs.batch_id')
        ->join('courses as co','co.id','=','bt.course_id')
        ->join('subjects as su','su.id','=','cs.subject_id')
        ->join('teachers as th','th.id','=','cs.teacher_id')
        ->join('users as us','us.id','=','th.user_id')
        ->leftJoin('classroom_users as cus','cus.classroom_id','=','cs.id')
        ->select('cs.id','cs.name','cs.classroom_join_id','cs.teacher_id','cs.subject_id','cs.meet_link', 'cs.batch_id','co.course_name','su.subject_name','us.id as user_id','us.full_name as teacher_name',
        'bt.start_year as batch_start_year', 'bt.end_year as batch_end_year',
        DB::raw('COUNT(cus.id) as total_students'))
        ->groupBy('cs.id','cs.name','cs.classroom_join_id','cs.teacher_id','cs.subject_id','cs.meet_link','cs.batch_id','co.course_name','su.subject_name','us.id','us.full_name',
        'bt.start_year', 'bt.end_year')
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

    
    public function createClassroom(Request $request){
        $subject_name = $request->subject['subject_name'];
        $course_id = $request->course['id'];
        $course_name = $request->course['course_name'];
        
        DB::beginTransaction();
    try{
        if($course_id){
            $course = \App\Models\Course::findOrFail($course_id);
        }else{
            $course=\App\Models\Course::create([
                'course_url'=>\Str::slug($course_name),
                'course_name'=>$course_name,
                'category_id'=>null
            ]);
            Log::warning('New course created',['course_id'=>$course->id]);
        }

        $subject= \App\Models\Subject::getOrCreate(null, $subject_name, $course->category_id, true);

        \App\Models\CourseSubject::firstOrCreate([
            'subject_id'=>$subject->id,
            'course_id'=>$course->id,
        ]);

        $batch = Batch::firstOrCreate([
            'institute_id'=>Auth::teacher()->instituteId,
            'course_id'=>$course->id,
            'start_year'=>$request->start_year,
            'end_year'=>$request->end_year,
        ]);

        $classroom_exist = Classroom::where([
            'name'=>$request->name,
            'batch_id'=>$batch->id,
        ])->exists();

        if($classroom_exist){
            return response()->json(['error'=>[
                'name'=>'Classroom name already exists in batch.Try other name.'
            ]], 422);
        }
        
        $classroom=new Classroom;
        $classroom->name=$request->name;
        $classroom->teacher_id=Auth::teacher()->id;
        $classroom->subject_id=$subject->id;
        $classroom->batch_id=$batch->id;
        $classroom->save();

        Log::info('New classroom created',[
            'name'=>$classroom->name,
            'user'=>Auth::id(),
            'join_id'=>$classroom->join_id]);
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::critical('classroom create failure',['data'=>$request->all(),'error'=>$e->getMessage()]);
        return response()->$e;
    }
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
    public function classroomListDetails(){

        $classroom_query = DB::table('classrooms as cl')
        ->leftjoin('classroom_users','classroom_users.classroom_id','=','cl.id')
        ->leftjoin('daily_assignments','cl.id','=','daily_assignments.classroom_id')
        ->leftjoin('teachers','cl.teacher_id','=','teachers.id')
        ->leftjoin('users','teachers.user_id','=','users.id')
        ->leftjoin('subjects','cl.subject_id','=','subjects.id')
        ->leftjoin('classroom_resources','cl.id','=','classroom_resources.classroom_id')
        ->leftjoin('classroom_messages','cl.id','=','classroom_messages.classroom_id')
        ->leftjoin('doubts','cl.id','=','doubts.classroom_id')
        ->leftjoin('daily_reports','daily_assignments.id','=','daily_reports.daily_assignment_id')
        ->select(DB::raw('COUNT(classroom_resources.id) as total_resources'),
                'subjects.subject_name as subject_name',
                'users.full_name AS teacher',
                'cl.classroom_join_id as join_id',
                'cl.name as classroom_name',
                DB::raw('COUNT(distinct classroom_users.user_id) AS total_students'),
                DB::raw('COUNT(distinct daily_assignments.id) AS total_daily_assignments'),
                DB::raw('COUNT(classroom_messages.id) as total_messages'),
                DB::raw('COUNT(doubts.id) as total_doubts'),
                DB::raw('FORMAT(AVG(daily_reports.marks_obtained),2) as average_score')
                )
        ->groupBy('cl.id','users.full_name','subjects.subject_name','cl.name','cl.classroom_join_id');
        $classrooms = [];

        $teacher=Auth::teacher();
        if($teacher){
            $classrooms=$classroom_query->where('cl.teacher_id','=',$teacher->id)->get();
            
        }else if(Auth::student()){
            $classrooms=$classroom_query->join('classroom_users as cu',function($join){
                $join->on('cu.classroom_id','=','cl.id')->where('cu.user_id',Auth::id());
            })
            ->get();
        }else if(Auth::instituteAdmin()){
            $classrooms=$classroom_query->join('batches as bt',function($join){
                $join->on('bt.id','=','cl.batch_id')->where('bt.institute_id',Auth::instituteAdmin()->institute_id);
            })
            ->get();
        }
        return response()->json([
            'success'=>[
                'classrooms' => $classrooms
            ]
        ]);
    }
}
