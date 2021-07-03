<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('notifications');

        Schema::create('notifications', function($table){
            $table->integer('scheduled_job_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('title');
            $table->string('body');
            $table->string('avatar_url');
            $table->string('avatar_name');
            $table->string('url');
            $table->dateTime('read_at')->nullable();
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
        //
    }
}
