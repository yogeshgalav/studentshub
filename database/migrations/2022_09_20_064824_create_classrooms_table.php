<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('institute_id');
            $table->timestamps();
        });
        Schema::table('classrooms', function (Blueprint $table){
            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('category_id')
            ->references('id')->on('categories')->onDelete('cascade');

            $table->foreign('course_id')
            ->references('id')->on('courses')->onDelete('cascade');

            $table->foreign('subject_id')
            ->references('id')->on('subjects')->onDelete('cascade');

            $table->foreign('institute_id')
            ->references('id')->on('institutes')->onDelete('cascade');
            
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
