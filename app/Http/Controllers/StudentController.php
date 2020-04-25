<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Notification;
use Auth;
use DB;
use Log;
use App\Models\Student;
use App\Models\Course;
use App\Models\Category;
use App\Models\Institute;
use App\Models\Batch;
use App\Models\BatchStudent;
use App\Notifications\BatchNewUserNotification;
use Illuminate\Support\Arr;
use SKAgarwal\GoogleApi\PlacesApi;

class StudentController extends Controller
{
    //
    public function create(Request $request)
    {
        $input = $request->all();
        $user=Auth::user();
        
    DB::beginTransaction();
    try{
        //create or get course id
        if($input['course']['id']){
            $course=Course::findOrFail($input['course']['id']);
        }else{
            //if new course insert course_type and course_level
            $category=Category::where('name',$input['course']['category'])->first();
            $course=Course::create([
                'course_name'=>$input['course']['course_name'],
                'category_id'=>$category->id,
                'course_level'=>$input['course']['course_level'],
            ]);
        }
        //create or get institute id
        $institute=Institute::firstOrCreate([
            'name'=>$input['institute']['name'],
        ],[
            'added_by_user_id'=>$user->id
        ]);
        
        //create or get batch id
        $batch=Batch::firstOrCreate([
            'end_year'=>$input['end_year'],
            'institute_id'=>$institute->id,
            'course_id'=>$course->id,
        ],[
            'start_year'=>$input['start_year'],
        ]);

        $student=Student::firstOrCreate([
            'user_id'=>Auth::user()->id
        ],[
            'prefferred_batch'=>$batch->id,
            'prefferred_category'=>$course->category_id,
            'unique_college_id'=>$request->college_id,
        ]);
        
        BatchStudent::create([
            'batch_id'=>$batch->id,
            'student_id'=>$student->id,
            'is_preffered'=>true,
        ]);

        $batch_users=$batch->users()->whereNotIn('id',[$user->id]);
        Notification::send($batch_users, new BatchNewUserNotification($user,$batch));
        // Notification::send($user, new StudentOnboardingNotification($batch));
            
        
    DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        // dd($e->getMessage());
        \Log::critical('Student Registeration failure: for user id#'.$user->id.' with data '.implode(', ',Arr::flatten($input)));
        dd($e->getMessage(),$e->getLine());
        return response()->$e;
    }        
        $success['redirectUrl'] = '/';
        return response()->json(['success' => $success]);
    }

    public function courseList(Request $request){
        $courses=DB::table('courses as cor')->where('cor.course_name','LIKE','%'.$request->searchTerm.'%')
        ->leftJoin('categories as cat','cat.id','=','cor.category_id')
        ->leftJoin('batches as bat','cor.id','=','bat.course_id')
        ->select('cor.id','cor.course_name','cat.name as category',DB::raw("COUNT('bat.id') as totalBatch"))
        ->groupBy('cor.id','cor.course_name','cat.name')
        ->orderBy('totalBatch','DESC')->limit(10)->get();

        if(count($courses)==0 && empty($request->recursive)){
            $request->request->add(['recursive'=>true]);
            $terms=explode(' ',$request->searchTerm);
            $new_terms=[];
            foreach($terms as $term){
                $new_terms[]=substr($term,0,1).'%'.substr($term,-1);
            }
            $request->searchTerm=implode(' ',$new_terms);
            return $this->courseList($request);
        }

        return response()->json(['success'=>[
            'courses'=>$courses
        ]]);
    }
    
    public function instituteList(Request $request){
        $input=$request->searchTerm;
    try{
        $institutes=DB::table('institutes as ins')->where('ins.name','LIKE',$input.'%')
        ->leftJoin('batches as bat','ins.id','=','bat.institute_id')
        ->select('ins.id','ins.name',DB::raw("COUNT('bat.id') as totalBatch"))
        ->groupBy('ins.id','ins.name')
        ->orderBy('totalBatch','DESC')->limit(10)->get();
        
        if(count($institutes)==0){
            $institutes=[];
            $api_key=config('keys.google_place_api');
            $googlePlaces = new PlacesApi($api_key);
            $response = $googlePlaces->placeAutocomplete($input,['types'=>'establishment']);

            foreach($response->items->predictions as $value){
                if($value->structured_formatting){
                    $institutes[]=[
                        'name'=>$value->structured_formatting->main_text,
                        'address'=>$value->structured_formatting->secondary_text
                    ];
                }
            }
        }
        
    }catch(\Exception $e){
        return response()->json(['success'=>[
            'institutes'=>[]
        ]]);
    }
        return response()->json(['success'=>[
            'institutes'=>$institutes
        ]]);
    }
}
