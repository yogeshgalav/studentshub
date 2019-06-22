<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrivateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('private_classrooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('classroom_id');
            $table->integer('teacher_id');
            $table->string('classroom_legal_name');
            $table->string('classroom_address_line');
            $table->string('classroom_address_line_2')->nullable();
            $table->string('classroom_city');
            $table->string('classroom_region')->nullable();
            $table->string('classroom_postal_code')->nullable();
            $table->char('classroom_country_code', 2);
            $table->char('classroom_locale_code',5);
            $table->string('last_contract_signed_date')->nullable();
            $table->string('next_contract_renewal_date')->nullable();
            $table->char('currency_code',3)->nullable();
            $table->timestamps();
        });

        // Schema::table('private_classrooms', function(Blueprint $table)
        // {
        //     $table->foreign('classroom_country_code')->references('country_code')->on('country')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('private_classrooms');
    }
}
