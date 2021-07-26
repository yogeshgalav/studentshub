<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdvanceSthubPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('user_institute_id');
            $table->integer('course_id')->unsigned()->nullable();
        });


        $sql = "update posts,sthub_posts set posts.course_id = sthub_posts.course_id where posts.id=sthub_posts.post_id";
        DB::unprepared($sql);

        Schema::table('sthub_posts', function (Blueprint $table) {
            $table->enum('action_type',['view','like','comment','share'])->nullable();
            $table->integer('action_user_id')->unsigned()->nullable();

            $table->dropColumn('shared_by_user_id');
            $table->dropColumn('liked_by_user_id');
            $table->dropColumn('commented_by_user_id');
            $table->dropColumn('course_id');
            $table->dropColumn('classroom_id');
        });
        
        $sql2 = "update sthub_posts,posts set sthub_posts.action_user_id=posts.user_id, sthub_posts.action_type='share' where posts.id=sthub_posts.post_id";
        DB::unprepared($sql2);
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
