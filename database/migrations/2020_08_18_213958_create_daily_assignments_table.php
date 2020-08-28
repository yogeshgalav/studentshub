<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_assignments', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->integer('unit_id')->unsigned();
            $table->integer('classroom_id')->unsigned();
            $table->date('attempt_date');
            $table->dateTime('activated_at')->nullable();
            $table->timestamps();
        });

        Schema::table('daily_assignments', function (Blueprint $table) {
            $table->unique(['classroom_id', 'attempt_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_assignments');
    }
}
