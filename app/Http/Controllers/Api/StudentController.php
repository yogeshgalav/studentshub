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

            //create or get batch id
            $batch = Batch::firstOrCreate([
                'end_year' => $input['end_year'],
                'institute_id' => $institute->id,
                'course_id' => $course->id,
            ], [
                'start_year' => $input['start_year'],
            ]);

            $student = Student::updateOrCreate([
                'user_id' => Auth::user()->id
            ], [
                'prefferred_batch' => $batch->id,
                'prefferred_category' => $course->category_id,
                'unique_college_id' => $request->college_id ?? null,
            ]);

            BatchStudent::updateOrCreate([
                'batch_id' => $batch->id,
                'student_id' => $student->id,
            ], [
                'is_preffered' => true,
            ]);

            $user->role_intended = 'student';
            $user->onboarded_at = \Carbon\Carbon::now()->toDateTimeString();
            $user->save();
            
            $batch_users = $batch->users()->whereNotIn('id', [$user->id]);
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

    public function courseList(Request $request)
    {
        $search = str_replace('.', '', $request->searchTerm);
        $courses = DB::table('courses as cor')
            ->where('cor.course_name', 'LIKE', '%' . $search . '%')
            ->orWhere('cor.alias', 'LIKE', '%' . $search . '%')
            ->leftJoin('batches as bat', 'cor.id', '=', 'bat.course_id')
            ->select('cor.id', 'cor.course_name', 'cor.category_id', DB::raw("COUNT('bat.id') as totalBatch"))
            ->groupBy('cor.id', 'cor.course_name', 'cor.category_id')
            ->orderBy('totalBatch', 'DESC')->limit(10)->get();

        // if(count($courses)==0 && empty($request->aliasSearch)){
        //     $request->request->add(['aliasSearch'=>true]);
        //     $new_terms=str_split(str_replace('.', '', $request->searchTerm));
        //     $request->searchTerm=implode('%',$new_terms);
        //     return $this->courseList($request);
        // }

        if (count($courses) == 0 && empty($request->recursive)) {
            $request->request->add(['recursive' => true]);
            $terms = explode(' ', $request->searchTerm);
            $new_terms = [];
            foreach ($terms as $term) {
                $new_terms[] = substr($term, 0, 1) . '%' . substr($term, -1);
            }
            $request->searchTerm = implode(' ', $new_terms);
            return $this->courseList($request);
        }

        return response()->json(['success' => [
            'courses' => $courses
        ]]);
    }
    public function subjectList(Request $request)
    {
        $search = str_replace('.', '', $request->searchTerm);
        $subjects = DB::table('subjects as sub')
            ->where('sub.subject_name', 'LIKE', '%' . $search . '%')
            ->orWhere('sub.alias', 'LIKE', $search)
            ->select('sub.subject_name')
            ->groupBy('subject_name')
            ->limit(10)->get();


        return response()->json(['success' => [
            'subjects' => $subjects
        ]]);
    }

    public function instituteList(Request $request)
    {
        $input = $request->searchTerm;
        try {
            $institutes = DB::table('institutes as ins')
                ->where('ins.name', 'LIKE', $input . '%')
                ->orWhere('ins.alias', 'LIKE', $input . '%')
                ->leftJoin('batches as bat', 'ins.id', '=', 'bat.institute_id')
                ->select('ins.id', 'ins.name', 'ins.address', 'ins.place_id', 'ins.description', DB::raw("COUNT('bat.id') as totalBatch"))
                ->groupBy('ins.id', 'ins.name', 'ins.address', 'ins.place_id', 'ins.description')
                ->orderBy('totalBatch', 'DESC')->limit(10)->get();

            if (count($institutes) == 0) {
                $institutes = [];
                $api_key = config('keys.google_place_api');
                $googlePlaces = new PlacesApi($api_key);
                $response = $googlePlaces->placeAutocomplete($input, ['types' => 'establishment'])->toArray();

                foreach ($response['predictions'] as $value) {
                    if (!in_array('university', $value['types'])) {
                        continue;
                    }
                    $institutes[] = [
                        'id' => 0,
                        'name' => $value['structured_formatting']['main_text'],
                        'address' => $value['structured_formatting']['secondary_text'],
                        'place_id' => $value['place_id'],
                        'description' => $value['description']
                    ];
                }
            }
        } catch (\Exception $e) {
            return response()->json(['success' => [
                'institutes' => []
            ]]);
        }
        return response()->json(['success' => [
            'institutes' => $institutes
        ]]);
    }

    public function getCourseSubjects()
    {
        $course = Course::where('id', Auth::student()->courseId)->with('subjects')->first();
        return response()->json(['success' => [
            'course' => $course
        ]]);
    }
}
