<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Doubt;
use App\Models\DoubtTag;
use App\Models\Post;
use App\Models\PostTag;

class AlterDoubtsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doubts', function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
        });

        foreach(Doubt::get() as $doubt){
            DoubtTag::create([
                'doubt_id'=>$doubt->id,
                'subject_id'=>$doubt->subject_id,
            ]);
            $doubt->category_id = 14;
            $doubt->save();
        }
        foreach(Post::get() as $post){
            PostTag::create([
                'post_id'=>$post->id,
                'subject_id'=>$post->subject_id,
            ]);
        }
        Schema::table('doubts', function (Blueprint $table) {
            $table->dropColumn('course_id');
            $table->dropColumn('institute_id');
            $table->dropColumn('subject_id');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('subject_id');
            $table->integer('classroom_id')->unsigned()->nullable();
        });
    }

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
