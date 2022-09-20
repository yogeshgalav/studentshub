<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('heading');
            $table->string('content');
            $table->unsignedInteger('classroom_id');
            $table->string('primary_image_url');
            $table->string('slug');
            $table->timestamps();
        });
        Schema::table('posts', function (Blueprint $table){
            $table->foreign('classroom_id')
            ->references('id')->on('classrooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
