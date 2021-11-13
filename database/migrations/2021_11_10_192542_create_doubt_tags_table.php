<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoubtTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doubt_tags', function (Blueprint $table) {
            $table->id();
            $table->integer('doubt_id')->unsigned();
            $table->integer('subject_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('doubt_tags', function (Blueprint $table) {
            $table->foreign('doubt_id')->references('id')->on('doubts')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->unique(['doubt_id','subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doubt_tags');
    }
}
