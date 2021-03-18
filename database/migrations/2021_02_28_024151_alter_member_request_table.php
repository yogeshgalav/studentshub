<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMemberRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('member_requests', function (Blueprint $table) {
            $table->dropColumn('plan');
            $table->integer('total_students');
        });
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_no')->unique()->nullable();
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
