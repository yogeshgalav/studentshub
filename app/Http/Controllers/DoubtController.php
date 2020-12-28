<?php

namespace App\Http\Controllers;
use App\Models\Doubt;
use App\Models\DoubtRequest;
use App\Models\Subject;
use App\Models\Category;
use Illuminate\Http\Request;
use Auth;
use Arr;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DoubtController extends Controller
{
    public function indexPage()
    {
        $categories = Category::all();
        return view('student.doubts')->with('categories',$categories);
    }

    public function addDoubt (Request $request)
    {
        $student=Auth::student();
        $selected_subject=$request->subject;

        if(is_null($student)){
            abort(403);
        }

        DB::beginTransaction();
    try{

        if($selected_subject['id']){
            $subject = Subject::findOrFail($selected_subject['id']);
        }else{
            $subject_name=strtolower($selected_subject['subject_name']);
            $subject=Subject::firstOrCreate([
                'subject_url'=>\Str::slug($subject_name),
                ],[
                'subject_name'=>$subject_name,
                'category_id'=>$student->categoryId
                ]);
        }

        $q = new Doubt();
        $q->user_id = Auth::user()->id;
        $q->question = $request->doubt;
        $q->subject_id = $subject->id;
        $q->batch_id = $student->batchId;
        $q->classroom_id = $request->classroomId ?? null;
        $q->save();


    DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('Doubt Creation failure',['user_id'=>Auth::id(),'request_data'=>$request->all()]);
            // dd($e->getMessage(),$e->getLine());
            return response()->$e;
        }
        return 'success';
    }

    public function getDoubts(Request $request)
    {
        $student=Auth::student();
        $doubt_query=Doubt::join('users as us','us.id','=','doubts.user_id')
        ->join('batches as pbt','pbt.id','=','doubts.batch_id')
        ->join('institutes as inst','inst.id','=','pbt.institute_id')
        ->join('subjects as sub','sub.id','=','doubts.subject_id');
        
        if(!empty($request->classroomId)){
            $doubt_query = $doubt_query->where('classroom_id',$request->classroomId);
        }
        if(!empty($request->search)){
            $doubt_query = $doubt_query->where('question','LIKE','%'.$request->search.'%');
        }

        $doubts = $doubt_query
        ->select('us.full_name as user_name','us.avatar_url as profile_image','sub.subject_name','inst.name as inst_name',
        'doubts.question','doubts.created_at','doubts.id')
        ->get();

        foreach($doubts as $doubt){
            $doubt_content = DB::table('doubts')->where('doubts.id',$doubt->id)
            ->leftJoin('doubt_answers as ans','doubts.id','=','ans.doubt_id')
            ->leftJoin('likes as li',function($join){
                $join->on('doubts.id','=','li.likable_id')->where('li.likable_type','=','App\Models\Doubt')->where('li.like_status','=',1);
            })
            ->select(DB::raw('COUNT(distinct li.user_id) as total_likes'),DB::raw('COUNT(distinct ans.user_id) as total_answers'))
            ->groupBy(['doubts.id'])
            ->first();
            $doubt->total_likes=$doubt_content->total_likes;
            $doubt->total_answers=$doubt_content->total_answers;
            $doubt->time=Carbon::createFromTimeStamp(strtotime($doubt->created_at))->diffForHumans();
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

}
