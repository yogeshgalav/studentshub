<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('classroom_live_id');
            $table->integer('teacher_id')->unsigned();
            $table->integer('subject_id')->unsigned();
            $table->integer('course_id')->unsigned();
            $table->integer('current_batch_id')->unsigned()->nullable();
            $table->integer('expected_students')->nullable();
            $table->integer('classroom_duration')->nullable();
            $table->integer('activated_unit')->nullable();
            $table->dateTime('estimated_start_date')->nullable();
            $table->dateTime('estimated_end_date')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classrooms');
    }
}
