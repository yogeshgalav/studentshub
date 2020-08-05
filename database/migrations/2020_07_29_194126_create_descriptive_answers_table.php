<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescriptiveAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descriptive_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('descriptive_question_id')->unsigned();
            $table->bigInteger('post_id')->unsigned();
            $table->string('answer_text');
            $table->string('answer_html_content');
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
        Schema::dropIfExists('formative_answers');
    }
}
