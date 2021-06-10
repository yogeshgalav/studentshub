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
            $table->integer('institute_id')->unsigned();
            $table->integer('course_id')->unsigned();
        });
        $sql = "update classrooms,teachers set classrooms.teacher_user_id = teachers.user_id,classrooms.institute_id=teachers.institute_id where teacher_user_id=teachers.id";
        DB::unprepared($sql);
        $sql = "update classrooms,batches set classrooms.course_id=batches.course_id,classrooms.institute_id=batches.institute_id where classrooms.batch_id=batches.id";
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
