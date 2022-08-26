<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Category;
use App\Models\CourseSubject;

class SubjectController extends Controller
{
    // 

    public function index(Request $request)
    {
        $me_id = $request->user('api')->id;
        $subject_query = DB::table('subjects as sub');
        if(!empty($request->searchTerm)){
            $search = str_replace('.', '', $request->searchTerm);
            $subject_query = $subject_query->where('sub.subject_name', 'LIKE', '%' . $search . '%')
            ->orWhere('sub.alias', 'LIKE', $search);
        }
        if(!empty($request->categoryId)){
            $subject_query=$subject_query->where('category_id','=',$request->categoryId);
        }
        $subjects=$subject_query
        ->leftJoin('votes as my_vote',function($join)use($me_id){
          $join->on('sub.id','=','my_vote.subject_id')->where('my_vote.user_id','=',$me_id);
        })
        ->leftJoin('votes as total_upvote',function($join){
            $join->on('sub.id','=','total_upvote.subject_id')->where('total_upvote.status','=',1);
        })
          ->leftJoin('votes as total_downvote',function($join){
            $join->on('sub.id','=','total_downvote.subject_id')->where('total_downvote.status','=',0);
        })
        ->select('sub.id','sub.subject_name',DB::raw('COUNT(DISTINCT total_upvote.id) as total_upvotes'),
        DB::raw('COUNT(DISTINCT total_downvote.id) as total_downvotes'), 'my_vote.status as myvote')
        ->groupBy('sub.id','sub.subject_name', 'my_vote.status')
            ->limit(10)->get();
            
        return response()->json(['success' => [
            'subjects' => $subjects
        ]]);
    }

    public function show(Request $request){
        $subject=\App\Models\Subject::where('slug', $request->route('id'))->firstOrFail();

        return response()->json(['success'=>[
            'subject'=>$subject,
        ]]);
      }
    
    public function getSubjects($dashboard_type=null,$dashboard_id=null,Request $request){
        $subject_repo=new \App\Subject;
        $subject_query=$subject_repo->getAuthUserSubjectTabels();
        $subject_query=$subject_query->orderBy('su.created_at','DESC');

      

        switch($dashboard_type){
          case 'course':
             $subject_query=$subject_query->leftJoin('course_subjects as co','co.subject_id','=','su.id')
             ->where('co.course_id',$dashboard_id);

            break;
          case 'subject':
            $subject_query=$subject_query->where('subject_id',$dashboard_id);
            break;
          case 'category':
            $subject_query=$subject_query->where('cat.id',$dashboard_id);
            break;
          case 'user':
            $subject_query=$subject_query->where('su.added_by_user_id',$dashboard_id);
            break;
          default:
            $subject_query=$subject_query;
            break;
        }
        
        if($request->user('api')){
          $me_id = $request->user('api')->id;
          $subject_vote=$subject_query
          ->leftJoin('votes as my_vote',function($join)use($me_id){
            $join->on('su.id','=','my_vote.subject_id')->where('my_vote.user_id','=',$me_id);
          })
          ->leftJoin('votes as total_upvote',function($join){
              $join->on('su.id','=','total_upvote.subject_id')->where('total_upvote.status','=',1);
          })
            ->leftJoin('votes as total_downvote',function($join){
              $join->on('su.id','=','total_downvote.subject_id')->where('total_downvote.status','=',0);
          })
          ->select('su.id','su.subject_name',DB::raw('COUNT(DISTINCT total_upvote.id) as total_upvotes'),
          DB::raw('COUNT(DISTINCT total_downvote.id) as total_downvotes'), 'my_vote.status as myvote')
          ->groupBy('su.id','su.subject_name', 'my_vote.status');

          $subjects=$subject_repo->formatSubjectData($subject_vote->paginate(10));
        }else{
          $subject_vote=$subject_query
          ->select('su.id','su.subject_name')
          ->groupBy('su.id','su.subject_name');

          $subjects['data']=$subject_repo->formatSubjectData($subject_vote->limit(10)->get());
        }
      
        return response()->json(['success'=>[
          'subjects'=>$subjects,
        ]]);
    }
    public function create($dashboard_type,$dashboard_id,Request $request) {
      $me = $request->user('api');
      switch($dashboard_type){
        case 'course':
          $course=DB::table('courses as co')->where('co.id',$dashboard_id)->first();
         $category_id=$course->category_id;
          break;
        case 'category':
          $category_id=$dashboard_id;
          break;
      }
     
      $subject = new Subject();
      $subject->subject_name = $request->subject_name;
      $subject->added_by_user_id =  $me->id;
      $subject->category_id = $category_id;
      $subject->save();

     if($dashboard_type='course'){
      $coursesubject =new CourseSubject();
      $coursesubject->course_id =$request->dashboard_id;
      $coursesubject->subject_id =$subject->id;
      $coursesubject->save();
     }

     return response()->json(['success'=>[
       'subject'=> $subject,
       'coursesubject'=>$coursesubject
   ]]); 
 }

}
