<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEulaAcceptanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eula_acceptance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->integer('eula_text_id')->unsigned();
            $table->ipAddress('ip_address');
            $table->timestamps();
        });

        // Schema::table('eula_acceptance', function(Blueprint $table)
        // {
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->foreign('eula_text_id')->references('id')->on('eula_text')->onDelete('cascade');
        //     //composite key
        //     $table->index(['user_id', 'eula_text_id']);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eula_acceptance');
    }
}
