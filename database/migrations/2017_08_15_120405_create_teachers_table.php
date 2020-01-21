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
            $table->string('introduction');
            $table->string('highest_degree')->comment('metric,graduate,post-graduate,phd');
            $table->boolean('verified');
            $table->string('last_contract_signed_date')->nullable();
            $table->string('next_contract_renewal_date')->nullable();
            $table->char('currency_code',3)->nullable();
            $table->boolean('is_demo_account');
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
