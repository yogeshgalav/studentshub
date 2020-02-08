<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoubtRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doubt_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('doubt_id')->unsigned();
            $table->integer('doubtable_id')->unsigned();
            $table->string('doubtable_type');
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
        Schema::dropIfExists('doubt_requests');
    }
}
