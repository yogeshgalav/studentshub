<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCorrectAnswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('multiple_choices', function (Blueprint $table) {
            $table->boolean('is_correct')->default(false);
        });
    
        $sql = "UPDATE multiple_choices 
            JOIN daily_questions as dq ON dq.id  = multiple_choices.daily_question_id
            SET multiple_choices.is_correct = (
            CASE WHEN multiple_choices.option_order = dq.correct_answer
            THEN 1
            ELSE 0
            END
        )";
        DB::unprepared($sql);
    
        Schema::table('daily_questions', function (Blueprint $table) {
            $table->dropColumn('correct_answer');
        });
        Schema::table('daily_answers', function (Blueprint $table) {
            $table->renameColumn('selected_answer', 'selected_option_id');
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
