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
    	return view('admin.index')->with(compact('Users','Posts','Batches','Institutes'));
    }

    public function show()
    {
		$students = Student::with('User')
		->with(['batches.institute','batches.course','batches.branch'])
		->get();
    	return view('admin.students')->with(compact('students'));
    }

    public function getPost($id)
    {
    	$posts = Post::where('user_id','=',$id)->get();
    	return view('admin.posts')->with(compact('posts'));
    }

    public function blockUpdate(Request $request)
    {
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

    public function explorePost()
    {
    	$fetchTopPost = ExplorePagePost::join('posts', 'posts.id', '=', 'explore_page_posts.post_id')->paginate(8);
    	return view('admin.posts.topPost')->with(compact('fetchTopPost'));
    }

    public function replace_post($id)
    {
    	$current_post_id = $id;
		$explorePost = ExplorePagePost::select('post_id')->get();
    	$fetchTopPost = Post::whereNotIn('id', $explorePost)->paginate(8);
    	return view('admin.posts.replacePost')->with(compact('fetchTopPost','current_post_id'));
	}

    public function updatePost($newPostId,$oldPostId)
    {
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
