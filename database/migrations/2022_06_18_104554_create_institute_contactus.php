<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstituteContactus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institute_contactus', function (Blueprint $table) {
            $table->id();
            $table->integer('institute_id')->unsigned();
            $table->string('department')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('phone_no2')->nullable();
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
        Schema::dropIfExists('institute_contactus');
    }
}
