<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('daily_assignment_id')->unsigned();
            $table->tinyInteger('question_order');
            $table->tinyInteger('correct_answer');
            $table->string('question_text');
            $table->enum('question_type',['multiple_choice'])->default('multiple_choice');
            $table->tinyInteger('marks');
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
        Schema::dropIfExists('daily_questions');
    }
}
