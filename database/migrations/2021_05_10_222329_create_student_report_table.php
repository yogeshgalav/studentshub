<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStudentReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->string('score_type');
            $table->integer('score');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->timestamps();
        });
        $sql = "INSERT INTO `student_reports` (`user_id`, `unit_id`, `score_type`,`score`)
        SELECT dr.user_id,da.unit_id,'first',dr.marks_obtained
        FROM daily_reports as dr
        LEFT JOIN daily_assignments as da
        ON dr.daily_assignment_id=da.id";
        DB::unprepared($sql);

        $sql = "INSERT INTO `student_reports` (`user_id`, `unit_id`, `score_type`,`score`)
        SELECT dr.user_id,da.unit_id,'last',dr.marks_obtained
        FROM daily_reports as dr
        LEFT JOIN daily_assignments as da
        ON dr.daily_assignment_id=da.id";
        DB::unprepared($sql);

        $sql = "INSERT INTO `student_reports` (`user_id`, `unit_id`, `score_type`,`score`)
        SELECT dr.user_id,da.unit_id,'average',dr.marks_obtained
        FROM daily_reports as dr
        LEFT JOIN daily_assignments as da
        ON dr.daily_assignment_id=da.id";
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
