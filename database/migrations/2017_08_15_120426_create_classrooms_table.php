<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('teacher_id');
            $table->integer('short_link');
            $table->string('classroom_type')->comment('college,private');
            $table->string('logo_url')->nullable();
            $table->string('locale_code',5)->nullable();
            $table->date('expires_at')->nullable();
            $table->boolean('is_demo_account');
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
        Schema::dropIfExists('classrooms');
    }
}
