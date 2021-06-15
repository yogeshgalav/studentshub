<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;

class SearchController extends Controller
{
    
    public function searchUser(Request $request){
        $users = DB::table('users as us')->where('us.full_name', 'LIKE', $request->searchTerm.'%')
            ->leftJoin('students as st', 'st.user_id', '=', 'us.id')
            ->leftJoin('courses', 'courses.id', '=', 'st.course_id')
            ->leftJoin('teachers as th', 'th.id', '=', 'th.user_id')
            ->leftJoin('institutes as inst', 'inst.id', '=', 'us.preferred_institute_id')
            ->select(
                'us.full_name as user_name',
                'inst.name as user_institute',
                'courses.course_name as user_course',
                'st.id as student_id',
                'th.id as teacher_id'
            )
            ->groupBy('us.id')
            ->limit(10)->get();

            return response()->json([
                'success'=>[
                    'users'=>$users,
                ]
            ]);
    }

    public function courseList(Request $request)
    {
        $search = str_replace('.', '', $request->searchTerm);
        $courses = DB::table('courses as cor')
            ->where('cor.course_name', 'LIKE', '%' . $search . '%')
            ->orWhere('cor.alias', 'LIKE', '%' . $search . '%')
            ->leftJoin('students as st', 'cor.id', '=', 'st.course_id')
            ->select('cor.id', 'cor.course_name', 'cor.category_id', DB::raw("COUNT('st.id') as totalStudent"))
            ->groupBy('cor.id', 'cor.course_name', 'cor.category_id')
            ->orderBy('totalStudent', 'DESC')->limit(10)->get();

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

        $institutes = DB::table('institutes as ins')
        ->where('ins.name', 'LIKE', $input . '%')
        ->orWhere('ins.alias', 'LIKE', $input . '%')
        ->leftJoin('students as st', 'ins.id', '=', 'st.institute_id')
        ->select('ins.id', 'ins.name', DB::raw("COUNT('st.id') as totalStudent"))
        ->groupBy('ins.id', 'ins.name')
        ->orderBy('totalStudent', 'DESC')->limit(10)->get();

        return response()->json(['success' => [
            'institutes' => $institutes
        ]]);
    }

    public function searchPosts(Request $request){
        $post=new \App\Post;
        $posts = $post->getSearchPosts($request);

        return response()->json(['success'=>[
        'posts'=>\Sthub::convert_from_latin1_to_utf8_recursively($posts)
        ]]);
    }
}
