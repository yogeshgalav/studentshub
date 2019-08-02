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
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('full_name', 101)->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->char('timezone_code',9)->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->char('country_code',2)->default('IN');
            $table->char('locale_code',2)->default('EN');
            $table->string('password');
            $table->boolean('is_knowledge_seeker')->default(true);
            $table->date('onboarded_at')->nullable();
            $table->string('avatar_url')->nullable();
            $table->softDeletes();
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
