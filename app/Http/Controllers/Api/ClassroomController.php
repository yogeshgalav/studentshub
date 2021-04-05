<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
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
        ->select('cs.id','cs.name','cs.classroom_join_id','cs.teacher_id','cs.subject_id','cs.batch_id','cs.expected_students','cs.classroom_duration','co.course_name','su.subject_name','us.id as user_id','us.full_name as teacher_name',
        'bt.start_year as batch_start_year', 'bt.end_year as batch_end_year',
        DB::raw('COUNT(cus.id) as total_students'))
        ->groupBy('cs.id','cs.name','cs.classroom_join_id','cs.teacher_id','cs.subject_id','cs.batch_id','cs.expected_students','cs.classroom_duration','co.course_name','su.subject_name','us.id','us.full_name',
        'bt.start_year', 'bt.end_year')
        ->first();

        return response()->json([
            'success'=>[
                'classroomDetail'=>$classroomDetail
            ]
        ]);
    }

    public function update($classroomId,Request $request){
        $classroom=Classroom::findOrFail($classroomId);
        $classroom->update([
            'name'=> $request->name,
            'expected_students'=> $request->expected_students,
            'classroom_duration'=> $request->duration,
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
}
