<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPasswordResetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('password_resets');
        Schema::create('password_resets', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->string('token')->index();
            $table->dateTime('expires_at');
            $table->timestamp('created_at');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dateTime('onboarded_at')->nullable();
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
