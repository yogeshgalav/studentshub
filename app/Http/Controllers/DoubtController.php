<?php

namespace App\Http\Controllers;
use App\Models\Doubt;
use App\Models\DoubtRequest;
use App\Models\Subject;
use Illuminate\Http\Request;
use Auth;
use Arr;
use DB;
use Carbon\Carbon;

class DoubtController extends Controller
{
    
    public function addDoubt (Request $request)
    {
        $input = $request->all();
        $student=Auth::student();
        
        if(is_null($student)){
            abort(403);
        }

        DB::beginTransaction();
    try{

        $subject_name=strtolower($request->subject);
        $subject=Subject::firstOrCreate([
            'subject_url'=>urlencode($subject_name),
            ],[
            'Subject_name'=>$subject_name,
            'category_id'=>$student->categoryId
            ]);  

        $q = new Doubt();
        $q->user_id = Auth::user()->id;
        $q->question = $request->doubt;
        $q->subject_id = $subject->id;
        $q->batch_id = $student->batchId;
        $q->save();

        
    DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::critical('Doubt Creation failure: for user id#'.Auth::user()->id.' with data '.implode(', ',Arr::flatten($input)));
            dd($e->getMessage(),$e->getLine());
            return response()->$e;
        }        
        return 'success';
    }

    public function getDoubts(Request $request)
    {
        $student=Auth::student();
        $doubts=Doubt::whereHas('subject.course_subjects',function($query)use($student){
            $query->where('course_id','=',$student->courseId);
        })
        ->orWhere('batch_id',$student->batchId)
        ->join('users as us','us.id','=','doubts.user_id')
        ->join('batches as pbt','pbt.id','=','doubts.batch_id')
        ->join('institutes as inst','inst.id','=','pbt.institute_id')
        ->join('subjects as sub','sub.id','=','doubts.subject_id')
        ->select('us.full_name as user_name','sub.Subject_name','inst.name as inst_name','doubts.question','doubts.created_at','doubts.id',)
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

    public function searchDoubts(Request $request){
        $search=implode('%',$this->extractKeyWords($request->query));
        $Doubts=Doubt::where('question','LIKE','%',$search,'%')->get();

        return response()->json([
            'success'=>[
                'doubtList'=>$Doubts
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
