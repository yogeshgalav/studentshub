<?php

namespace App\Http\Controllers;
use App\Models\Like;
use App\Models\User;
use App\Models\Post;
use App\Models\Batch;
use App\Models\Student;
use App\Models\Course;
use App\Models\Category;
use App\Models\Institute;
use App\Models\ExplorePagePost;
use App\Models\Branch;
use App\Models\BatchStudent;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index()
    {
    	$Users =  User::count();
    	$Posts =  Post::count();	
    	$Batches = Batch::count();
    	$Institutes = Institute::count();
    	//$Colleges = College::count();
    	//dd($Students->toArray());
    	return view('admin.index')->with(compact('Users','Posts','Batches','Institutes'));
    }

    public function show()
    {
    	/*$batches = Post::with('user')->get();
    	dd($batches);*/
    	$students = Student::with('User')->with('batches')->with('institutes')->with('courses')->with('branches')->get();
    	// $t = BatchStudent::with('')->get();
    	//$t = BatchStudent::with('batch_students')->get();
    	//dd($students);
    	return view('admin.students')->with(compact('students'));
    }

    public function getPost($id)
    {	
    	/*select('id','post_heading')->*/

    	$posts = Post::where('user_id','=',$id)->get();
    	return view('admin.posts')->with(compact('posts'));
    }

    public function blockUpdate(Request $request)
    {
    	/*dd($request->id);*/
    	$id = $request->id;
        $raj = Student::where('user_id','=',$id)->update(array('block_status' => '1'));
  		return 'success';
    }

    public function unblockUpdate(Request $request)
    {
    	$id = $request->id;
        $raj = Student::where('user_id','=',$id)->update(array('block_status' => '0'));
		return 'success';
    }

   /* public function topPost($value)
    {
    	if($value=="top")
    		$postType="ExploreTopPost";
    	else if($value=="bottom")
    		$postType="ExploreBottomPost";
    	else if($value=="side")
    		$postType="ExploreSideBar";
    	else if($value=="main")
    		$postType="HomePostContainer";

    	$topPost = ExplorePagePost::where('page_section','=',$postType)->select('post_id')->get();
    	$fetchTopPost = Post::whereIn('id', $topPost)->get();
    	return view('admin.posts.topPost')->with(compact('fetchTopPost','value'));
    	dd($fetchTopPost);	
    }*/

    public function explorePost()
    {
    	//$explorePost = ExplorePagePost::select('post_id')->get();
    	/*$pageSection = Post::select('page_section')->get();*/
    	$fetchTopPost = ExplorePagePost::join('posts', 'posts.id', '=', 'explore_page_posts.post_id')->get();
    	//dd($fetchTopPost);
    	return view('admin.posts.topPost')->with(compact('fetchTopPost'));
    }

    public function replace_post($id)
    {
    	$current_post_id = $id;
		$explorePost = ExplorePagePost::select('post_id')->get();
    	$fetchTopPost = Post::whereNotIn('id', $explorePost)->get();
    	return view('admin.posts.replacePost')->with(compact('fetchTopPost','current_post_id'));
    	//dd($fetchTopPost);
    }

    public function updatePost($newPostId,$oldPostId)
    {
    	/*echo $newPostId;dd($oldPostId);*/
    	$updatePost = ExplorePagePost::where('post_id','=',$oldPostId)
    	->update(array('post_id' => $newPostId));
		return redirect('/explorePost');
    }

    public function getPostDetails($id)
    {
    	$posts = Post::where('id','=',$id)->get();
    	$like = Like::where([
       'post_id' => $id,
       'like' => '1'
			])->count();
    	$disLike = Like::where([
       'post_id' => $id,
       'like' => '0'
			])->count();
    	return view('admin.postDetails')->with(compact('like','disLike','posts'));
    }
}
