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
            ->leftJoin('batches as pbt', 'pbt.id', '=', 'st.prefferred_batch')
            ->leftJoin('institutes as inst', 'inst.id', '=', 'pbt.institute_id')
            ->leftJoin('courses', 'courses.id', '=', 'pbt.course_id')
            ->leftJoin('teachers as th', 'th.id', '=', 'th.user_id')
            ->leftJoin('institutes as inst2', 'inst2.id', '=', 'th.institute_id')
            ->select(
                'inst.id as instituteId',
                'inst.name as instituteName',
                'courses.id as courseId',
                'courses.course_name as courseName',
                'courses.course_url as courseUrl',
                'pbt.id as batchId',
                'pbt.start_year as start_year',
                'pbt.end_year as end_year',
                'st.prefferred_batch as preferred_batch',
                'st.prefferred_category as preferred_category',
                'inst2.id as instituteId',
                'inst2.name as instituteName',
                'th.id as id', 'th.user_id'
            )->limit(10)->get();

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

            // if (count($institutes) == 0) {
            //     $institutes = [];
            //     $api_key = config('keys.google_place_api');
            //     $googlePlaces = new PlacesApi($api_key);
            //     $response = $googlePlaces->placeAutocomplete($input, ['types' => 'establishment'])->toArray();

            //     foreach ($response['predictions'] as $value) {
            //         if (!in_array('university', $value['types'])) {
            //             continue;
            //         }
            //         $institutes[] = [
            //             'id' => 0,
            //             'name' => $value['structured_formatting']['main_text'],
            //             'address' => $value['structured_formatting']['secondary_text'],
            //             'place_id' => $value['place_id'],
            //             'description' => $value['description']
            //         ];
            //     }
            // }
        } catch (\Exception $e) {
            return response()->json(['success' => [
                'institutes' => []
            ]]);
        }
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
