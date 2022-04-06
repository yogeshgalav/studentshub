<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Career;
use App\Models\Course;
use App\Models\User;
use App\Models\Lead;
use DB;

class StaffController extends Controller
{
   //
   public function leadIndexPage(){        
        return inertia('staff/lead-index');
    }
    
   public function leadShowPage($id, Request $request){
      //   $leadData = DB::table('leads as le')->where('le.user_id','=',$id)
      //  ->leftJoin('users as us', 'us.id','=','le.user_id')
      //  ->select('us.id as user_id','us.full_name as user_name','lead_status', 'description')->first();   
        $leadData = DB::table('users as us')->where('us.id','=',$id)
       ->leftJoin('leads as le', 'le.user_id','=','us.id')
       ->select('us.id as user_id','us.full_name as user_name','le.lead_status as lead_status', 'le.description as description')->first();   

        return inertia('staff/lead-show', ['leadData' => $leadData]);
    }

   public function manageCoursePage(){        
    $categories = \App\Models\Category::get();  
    $courses=DB::table('courses as co')
    ->leftJoin('categories as cat','cat.id','=','co.category_id')
->select(['co.course_name as course_name','co.id as course_id','co.alias as course_alias','cat.name as category_name','cat.id as category_id'])->get();
/*
SELECT courses.course_name as course_name, alias as course_alias ,categories.id as categories_id, categories.name as categories_name
FROM courses
LEFT JOIN categories
ON courses.category_id=categories.id
ORDER BY categories.name;
*/
    return inertia('staff/manage-course',[
        'courses'=>$courses,    
        'categories' => $categories
    ] );
    }
   public function manageJobsPage(){
     // $careers= Career::all(); 
      $careers=\DB::table('careers as ca')
         ->leftJoin('categories as cat','cat.id','=','ca.category_id')
        ->select(['ca.name as career_name','ca.id as career_id','cat.name as category_name','cat.id as category_id'])->get();
     /* SELECT careers.name as carrers_name, categories.id as categories_id, categories.name as categories_name
FROM careers
LEFT JOIN categories
ON careers.category_id=categories.id
ORDER BY careers.name;  */   
    $categories = \App\Models\Category::get();  
    return inertia('staff/manage-job',[
        'careers'=>$careers,
    'categories' => $categories
    ] );
    }
   public function userFeedbacksPage(){        
        return inertia('staff/user-feedbacks');
    }
   public function userReportsPage(){        
        return inertia('staff/user-reports');
    }
}
