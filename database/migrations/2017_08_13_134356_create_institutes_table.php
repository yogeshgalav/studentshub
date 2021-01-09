<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('place_id')->nullable();
            $table->string('description')->nullable();
            $table->char('country_code',2)->default('IN');
            $table->string('email_slug')->nullable();
            $table->string('regno_slug')->nullable();
            $table->string('alias')->nullable();
            $table->integer('added_by_user_id')->unsigned();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
        
        // Schema::table('institutes', function(Blueprint $table)
        // {
        //     $table->foreign('country_code')->references('country_code')->on('country')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institutes');
    }
}
