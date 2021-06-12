<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\CheckinRequest;
use Notification;
use Auth;
use DB;
use App\Models\Student;
use App\Models\Course;
use App\Models\Category;
use App\Models\Institute;
use App\Notifications\BatchNewUserNotification;
use App\Notifications\StudentOnboardingNotification;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use SKAgarwal\GoogleApi\PlacesApi;
use App\Http\Requests\StudentCreateRequest;

class StudentController extends Controller
{
    //
    public function create(StudentCreateRequest $request)
    {
        $input = $request->all();
        $user = Auth::user();
        
        $course = '';
        DB::beginTransaction();
        try {
            //create or get course id
            if ($input['course_id'] == 0) {
                Log::info('New course created',['course_id'=>$course->id]);
                $course = Course::create([
                    'course_name' => $input['course_name'],
                    'category_id' => null,
                ]);
            } else {
                $course = Course::findOrFail($input['course_id']);
            }
            //create or get institute id
            if(!empty($input['institute_id'])){
                $institute = Institute::find($input['institute_id']);
            }else{
                $institute = Institute::create([
                    'name' => $input['institute_name'],
                    'added_by_user_id' => $user->id,
                    'country_code' => 'IN',
                    'is_verified' => false,
                ]);
            }

            $student = Student::updateOrCreate([
                'user_id' => Auth::user()->id,
                'institute_id' => $institute->id,
                'course_id' => $course->id
            ], [
                'is_preferred' => 1,
                //'prefferred_category' => $course->category_id,
                'unique_college_id' => $request->college_id ?? null,
            ]);


            $user->role_intended = 'student';
            $user->onboarded_at = \Carbon\Carbon::now()->toDateTimeString();
            $user->save();
            
           // $batch_users = $batch->users()->whereNotIn('id', [$user->id]);
            // Notification::send($batch_users, new BatchNewUserNotification($user,$batch));
            // Notification::send($user, new StudentOnboardingNotification(count($batch_users)));


            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e->getLine(),$e->getMessage());
            Log::critical('Student Registeration failure',['error'=>$e->getMessage()]);
            return response()->$e;
        }
        $success['redirectUrl'] = '/classrooms';
        return response()->json(['success' => $success]);
    }

    public function getCourseSubjects()
    {
        $course = Course::where('id', Auth::student()->courseId)->with('subjects')->first();
        return response()->json(['success' => [
            'course' => $course
        ]]);
    }
}
