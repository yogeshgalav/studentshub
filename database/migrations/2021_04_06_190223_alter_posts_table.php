<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\Post;
use \App\Models\SthubPost;

class AlterPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // public function up()
    // {
    //     Schema::table('posts', function($table)
    //     {
    //         $table->integer('subject_id')->nullable()->change();
    //         $table->integer('category_id')->unsigned();
    //         $table->foreign('subject_id')->references('id')->on('subjects'); 
    //         $table->foreign('category_id')->references('id')->on('categories'); 
    //     });

    //     $posts = Post::get();
    //     foreach($posts as $post){
    //         $post->category_id = $post->subject->category_id;
    //         $post->save();
    //         SthubPost::where('post_id', $post->id)
    //         ->update(['category_id', $post->category_id]);
    //     }
        
    //     Schema::table('posts', function($table)
    //     {
    //         $table->foreign('subject_id')->references('id')->on('subjects'); 
    //         $table->foreign('category_id')->references('id')->on('categories'); 
    //     });
    //     Schema::table('sthub_posts', function($table)
    //     {
    //         $table->foreign('post_id')->references('id')->on('posts'); 
    //         $table->foreign('category_id')->references('id')->on('categories'); 
    //         $table->foreign('course_id')->references('id')->on('courses');
    //         $table->foreign('classroom_id')->references('id')->on('classrooms'); 
    //         $table->foreign('batch_id')->references('id')->on('batches'); 
    //         $table->foreign('institute_id')->references('id')->on('institutes'); 
    //         $table->foreign('shared_by')->references('id')->on('users'); 
    //     });
    // }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
