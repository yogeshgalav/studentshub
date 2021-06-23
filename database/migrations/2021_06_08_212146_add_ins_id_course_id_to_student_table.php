<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInsIdCourseIdToStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            //
            $table->integer('institute_id')->unsigned();
            $table->integer('course_id')->unsigned();
            $table->boolean('is_preferred')->default(1);
            $table->dropForeign(['prefferred_batch']);
            $table->dropForeign(['prefferred_category']);
            $table->dropColumn(['prefferred_batch', 'prefferred_category']);
        });
        $sql = "update students,batch_students,batches set students.institute_id=batches.institute_id,students.course_id=batches.course_id where students.id=batch_students.student_id and batch_students.batch_id=batches.id";
        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
