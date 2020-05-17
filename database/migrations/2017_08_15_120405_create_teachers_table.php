<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->string('field_of_expertise')->comment('Academic Tutoring,Languages,Computer Science,Music,Sports,Arts and Hobbies,Health and well-being,Professional Development');
            $table->string('payment_method')->nullable();
            $table->string('payment_no')->nullable();
            $table->string('verification_document_url');
            $table->boolean('verified')->default(false);
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
        Schema::dropIfExists('teachers');
    }
}
