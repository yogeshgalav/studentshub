<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtpToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->text('description');
            $table->enum('lead_status',[
                'raw',
                'invalid',
                'notInterested',
                'interested',
                'paymentPending',
                'paymentDone',
            ])->default('raw');
            $table->timestamps();
        });
        
        Schema::create('lead_assigned', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lead_id')->unsigned();
            $table->integer('staff_user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('full_name')->nullable()->change();
            $table->renameColumn('role_intended','role');
            $table->renameColumn('email_verified_at','user_verified_at');
            $table->dropColumn('login_provider_id');
            $table->dropColumn('login_provider_type');
            $table->dropColumn('must_reset_password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            //
        });
    }
}
