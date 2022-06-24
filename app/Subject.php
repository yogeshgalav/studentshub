<?php

namespace App;

use App\Models\Subject as SubjectModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use DB;
use PHPHtmlParser\Dom;

class Subject extends SubjectModel
{
    public function getAuthUserSubjectTabels(){
        $subject_query = DB::table('subjects as su')
        ->leftJoin('categories as cat','cat.id','=','su.category_id');
        
        $columns = ['su.id as subject_id','su.subject_name as subject_name','cat.name','cat.id'];
        $groupBycolumns = ['su.id','subject_name','cat.name','cat.id'];

        if(Auth::check()){
            $subject_query->leftJoin('votes as vo',function($join){
                $join->on('su.id','=','vo.subject_id')->where('vo.status','=','App\Models\Vote')->where('vo.user_id','=',Auth::user()->id);
            });
            array_push($columns,'vo.status as user_vote');
            array_push($groupBycolumns,'vo.status');
        }

        return $subject_query->select($columns)
        ->groupBy($groupBycolumns);
    }
    public function formatSubjectData($subjects){
        // $path =  (dirname(__FILE__) .'./Services/simple_html_dom.php');
        // require($path);
           //get groupBy fields
           foreach($subjects as $subject){
            $rand=rand(60,100);
            $subjectData=SubjectModel::where('id',$subject->id)
            ->with('subjects')
            ->first();
          
            // $subject->total_votes=\App\Models\Vote::where('subject_id',$subject->id)->where('status','=',1)->count();
        }

        return $subjects;
    } 
    
}
