<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->dateTime('first_purchase_at');
            $table->dateTime('last_purchase_at');
            $table->dateTime('expires_at');
            $table->string('current_plan');         
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
        Schema::dropIfExists('membership_details');
    }
}
