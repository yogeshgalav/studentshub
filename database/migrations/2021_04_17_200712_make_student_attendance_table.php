<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeStudentAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_attendance', function (Blueprint $table) {
            $table->id();
            $table->integer('attendance_id')->unsigned();
            $table->time('joined_at');
            $table->time('present_at')->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('student_attendance', function (Blueprint $table) {
            $table->foreign('attendance_id')->references('id')->on('attendance')->onDelete('cascade');
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
