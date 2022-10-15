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
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('course_id')->unsigned();
            $table->bigInteger('subject_id')->unsigned();
            $table->bigInteger('institute_id')->unsigned();
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
