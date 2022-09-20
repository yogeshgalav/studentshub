<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('classroom_followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('classroom_id');
            $table->unsignedInteger('follower_user_id');
            $table->timestamps();
        });
        Schema::table('classroom_followers', function (Blueprint $table){
            $table->foreign('classroom_id')
            ->references('id')->on('classrooms')->onDelete('cascade');
            $table->foreign('follower_user_id')
            ->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classroom_followers');
    }
}
