<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class AddingTeacherUserIdToClassrooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->renameColumn('teacher_id', 'teacher_user_id');
            $table->foreign('teacher_user_id')->references('id')->on('users')->onDelete('cascade');
        });
        $sql = "update classrooms,teachers set teacher_user_id = teachers.user_id where teacher_user_id=teachers.id";
        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classrooms', function (Blueprint $table) {
            //
        });
    }
}
