<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Notification;
use Auth;
use DB;
use App\Models\Student;
use App\Models\Course;
use App\Models\Category;
use App\Models\Institute;
use App\Models\Branch;
use App\Models\Batch;
use App\Models\BatchStudent;

class StudentController extends Controller
{
    //
    public function create(Request $request)
    {
        $input = $request->all();
    DB::beginTransaction();
    try{
        $student=Student::create(['user_id'=>Auth::user()->id]);
        //create or get course id
        if($input['course']['id']){
            $course=Course::findOrFail($input['course']['id']);
        }else{
            //if new course insert course_type and course_level
            $category=Category::where('name',$input['course']['course_type'])->first();
            $course=Course::create([
                'course_name'=>$input['course']['course_name'],
                'category_id'=>$category->id,
                'course_level'=>$input['course']['course_level'],
            ]);
        }
        //create or get institute id
        $institute=Institute::firstOrCreate([
            'institute_name'=>$input['institute'],
        ],[
            'added_by_user_id'=>Auth::user()->id
        ]);
        //create or get branch id
        if($input['branch']['id']){
            $branch=Branch::findOrFail($input['branch']['id']);
        }else{
            $branch=Branch::create([
                'branch_name'=>$input['branch']['branch_name'],
                'course_id'=>$course->id,
            ]);
        }
        //create or get batch id
        $batch=Batch::firstOrCreate([
            'start_year'=>$input['start_year'],
            'end_year'=>$input['end_year'],
            'institute_id'=>$institute->id,
            'course_id'=>$course->id,
            'branch_id'=>$branch->id,
        ]);

        BatchStudent::create([
            'batch_id'=>$batch->id,
            'student_id'=>$student->id,
            'is_preffered'=>true,
        ]);
        foreach($batch->students() as $student){
            Notification::send($student->user(), new BatchNewUserNotification($batch));
        }
        
    DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        // dd($e->getMessage(),$e->getLine());
        return response()->$e;
    }        
        $success['redirectUrl'] = '/';
        return response()->json(['success' => $success]);
    }
}
