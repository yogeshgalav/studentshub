<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_login', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('phone_number')->unique();
            $table->string('otp');
            $table->dateTime('expires_at');
            $table->string('fcm_token');
            $table->json('device_info');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('timezone');
            $table->string('postal_code');
            $table->string('ip');
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
        Schema::dropIfExists('user_login');
    }
}
