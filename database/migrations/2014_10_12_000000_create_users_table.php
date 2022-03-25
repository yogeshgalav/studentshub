<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name', 101);
            $table->string('email')->unique();
            $table->string('timezone')->default('Asia/Kolkata');
            $table->dateTime('email_verified_at')->nullable();
            $table->char('country_code',2)->default('IN');
            $table->char('locale_code',2)->default('EN');
            $table->string('password');
            $table->string('login_provider_id')->nullable();
            $table->string('login_provider_type')->nullable();
            $table->dateTime('last_login_at')->nullable();
            $table->integer('block_status')->default(0);
            $table->string('role')->default('student');
            $table->string('avatar_url')->nullable();
            $table->string('fcm_token')->nullable();
            $table->boolean('must_reset_password')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
