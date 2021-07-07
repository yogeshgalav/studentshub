<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPostInstitute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('preferred_institute_id')->unsigned()->nullable();
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->integer('user_institute_id')->unsigned();
        });

        $sql = "update posts,sthub_posts set posts.user_institute_id = sthub_posts.institute_id where posts.id=sthub_posts.post_id";
        DB::unprepared($sql);

        Schema::table('sthub_posts', function (Blueprint $table) {
            $table->renameColumn('shared_by', 'shared_by_user_id');
            $table->integer('liked_by_user_id')->unsigned()->nullable();
            $table->integer('commented_by_user_id')->unsigned()->nullable();

            $table->dropColumn('institute_id');
            $table->dropColumn('category_id');
            $table->dropColumn('batch_id');
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
