<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Doubt;
use App\Models\DoubtRequest;
use App\Models\Subject;
use App\Models\Category;
use App\Models\Classroom;
use App\Models\ScheduledJob;
use App\Models\DoubAnswer;
use Illuminate\Http\Request;
use Auth;
use Arr;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Notfications\NewDoubtNotification;

class DoubtController extends Controller
{

    public function create (Request $request)
    {
        DB::beginTransaction();
    try{
        // $subject=Subject::getOrCreate(null, $selected_subject['subject_name'], Auth::student()->categoryId);

        $me = $request->user('api');
        $doubt = new Doubt();
        $doubt->user_id = $me->id;
        $doubt->question = $request->question;
        $doubt->category_id = $request->category_id;
        $doubt->course_id=$me->preferred_course_id;
        $doubt->save();
        $subject=Subject::addDoubtTags($doubt, $request->selected_subjects);
        ScheduledJob::newDoubtNotification($doubt);


    DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('Doubt Creation failure',['data'=>$request->all(),'error'=>$e->getMessage()]);
            // dd($e->getMessage(),$e->getLine());
            return response()->$e;
        }

        Log::info('New Doubt created',[
            'user_id'=>$request->user('api')->id,
            'question'=>$request->question,
        ]);
        return response()->json(['success'=>[
          'doubt_id'=> $doubt->id,
      ]]); 
    }

    
    public function getDoubts(Request $request){

        $doubt_query = Doubt::join('users as us','us.id','=','doubts.user_id')
        ->join('categories as cat','cat.id','=','doubts.category_id')
        ->leftJoin('institutes as inst','inst.id','=','us.preferred_institute_id')
        ->leftJoin('doubt_answers as ans','doubts.id','=','ans.doubt_id')
        ->leftJoin('likes as li',function($join){
            $join->on('doubts.id','=','li.likable_id')->where('li.likable_type','=','App\Models\Doubt')->where('li.like_status','=',1);
        })
        ->leftJoin('likes as uli',function($join){
            $join->on('doubts.id','=','uli.likable_id')
            ->where('uli.likable_type','=','App\Models\Doubt')
            ->where('uli.user_id','=',Auth::id());
        })
        ->select('cat.id as category_id','cat.name as category_name',
        'us.id as user_id','us.full_name as user_name','us.avatar_url as profile_image',
        'inst.id','inst.name',
        'doubts.question','doubts.created_at','doubts.id','uli.like_status as user_like',
        DB::raw('COUNT(distinct li.user_id) as total_likes'),
        DB::raw('COUNT(distinct ans.user_id) as total_answers'))
        ->groupBy('cat.id','cat.name', 'us.id','us.full_name','us.avatar_url',
        'inst.id','inst.name',
        'doubts.question','doubts.created_at','doubts.id','uli.like_status');

        

        $dashboard_id = $request->route('dasboard_id');

        switch($request->route('dasboard_type')){
          case 'institute':
            $doubt_query=$doubt_query->where('inst.id',$institute_id)
            ->orderBy('doubts.created_at','DESC');
            break;
          case 'course':
            $posts=$post_query->where('doubts.course_id',$course_id)
            ->orderBy('doubts.created_at','DESC');
            break;
          case 'subject':
            $posts=$post_query->leftJoin('doubt_tags as dt','dt.doubt_id','=','doubts.id')
            ->where('dt.subject_id',$subject_id)
            ->orderBy('doubts.created_at','DESC');
            break;
          case 'category':
            $doubts=$doubt_query->where('cat.id',$category_id)
            ->orderBy('doubts.created_at','DESC');
            break;
          case 'user':
            $doubts=$doubt_query->where('doubts.user_id',$userId)
            ->orderBy('doubts.created_at','DESC');
            break;
          default:
            $doubts=$doubt_query->orderBy('doubts.created_at','DESC');
            break;
        }

        if($request->user('api')){
          $doubts=$doubt_query->limit(10)->get();
        }else{
          $doubts=$doubt_query->limit(10)->get();
        }
        
        foreach($doubts as $doubt){
            $doubt->subjects=$doubt->subjects()->get();
        }

        return response()->json(['success'=>[
          'doubts'=>$doubts
        ]]);
    }
    
    public function index(Request $request)
    {
        // $course_id = null;
        // if($request->classroomId){
        //     $course_id = Classroom::findOrFail($request->classroomId)->course_id;
        // }else if(Auth::student()){
        //     $course_id = Auth::student()->courseId;
        // }

        $doubt_query=Doubt::join('users as us','us.id','=','doubts.user_id')
        ->join('categories as cat','cat.id','=','doubts.category_id')
        ->leftJoin('institutes as inst','inst.id','=','us.preferred_institute_id');
        
        if(!empty($request->search)){
            $doubt_query = $doubt_query->where('question','LIKE','%'.$request->search.'%');
        }

        $doubts = $doubt_query
        ->leftJoin('doubt_answers as ans','doubts.id','=','ans.doubt_id')
        ->leftJoin('likes as li',function($join){
            $join->on('doubts.id','=','li.likable_id')->where('li.likable_type','=','App\Models\Doubt')->where('li.like_status','=',1);
        })
        ->leftJoin('likes as uli',function($join){
            $join->on('doubts.id','=','uli.likable_id')
            ->where('uli.likable_type','=','App\Models\Doubt')
            ->where('uli.user_id','=',Auth::id());
        })
        ->select('cat.id as category_id','cat.name as category_name',
        'us.id as user_id','us.full_name as user_name','us.avatar_url as profile_image',
        'inst.id','inst.name',
        'doubts.question','doubts.created_at','doubts.id','uli.like_status as user_like',
        DB::raw('COUNT(distinct li.user_id) as total_likes'),
        DB::raw('COUNT(distinct ans.user_id) as total_answers'))
        ->groupBy('cat.id','cat.name', 'us.id','us.full_name','us.avatar_url',
        'inst.id','inst.name',
        'doubts.question','doubts.created_at','doubts.id','uli.like_status')
        ->orderBy('doubts.created_at','DESC')
        ->get();

        foreach($doubts as $doubt){
            $doubt->time=Carbon::createFromTimeStamp(strtotime($doubt->created_at))->diffForHumans();
            $doubt->subjects=$doubt->subjects()->get();
        }

        return response()->json([
            'success'=>[
                'doubtList'=>$doubts
            ]
        ]);
    }

    function extractKeyWords($string) {
        mb_internal_encoding('UTF-8');
        $stopwords = array();
        $string = preg_replace('/[\pP]/u', '', trim(preg_replace('/\s\s+/iu', '', mb_strtolower($string))));
        $matchWords = array_filter(explode(' ',$string) , function ($item) use ($stopwords) { return !($item == '' || in_array($item, $stopwords) || mb_strlen($item) <= 2 || is_numeric($item));});
        $wordCountArr = array_count_values($matchWords);
        arsort($wordCountArr);
        return array_keys(array_slice($wordCountArr, 0, 5));
      }

      public function update(Doubt $doubt, Request $request){
        $student=Auth::student();
        $selected_subject=$request->subject;

        if($doubt->user_id!==Auth::id() || is_null($student)){
            abort(403);
        }

        DB::beginTransaction();
    try{
        $subject=Subject::getOrCreate(null, $selected_subject['subject_name'], Auth::student()->categoryId);

        $doubt->user_id = Auth::user()->id;
        $doubt->question = $request->doubt;
        $doubt->subject_id = $subject->id;
        $doubt->institute_id = $student->instituteId;
        $doubt->course_id = $student->courseId;
        $doubt->save();
        // ScheduledJob::newDoubtNotification($doubt);


    DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('Doubt edit failure',['data'=>$request->all(),'error'=>$e->getMessage()]);
            // dd($e->getMessage(),$e->getLine());
            return response()->$e;
        }
        return 'success';
      }

      public function delete(Doubt $doubt){
        $doubt->delete();
        return response()->json([], 204);
      }
}
