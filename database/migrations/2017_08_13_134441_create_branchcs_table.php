<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branchcs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('course_name');
            $table->string('branch_name');
            $table->integer('course_time')->comment('duration of course in years');
            $table->enum('type',['graduation','post-graduation','php']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branchcs');
    }
}
