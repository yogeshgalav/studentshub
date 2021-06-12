<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveBatchIdClassrooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        
        Schema::table('classrooms', function (Blueprint $table) {
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('institute_id')->references('id')->on('institutes');
            $table->dropForeign(['batch_id']);
            $table->dropColumn('batch_id');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('institute_id')->references('id')->on('institutes');
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
