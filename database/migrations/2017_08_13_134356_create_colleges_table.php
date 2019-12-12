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
            $table->bigIncrements('id');
            $table->string('institute_type');
            $table->string('institute_name');
            $table->string('institute_city');
            $table->string('institute_state');
            $table->string('subdomain');
            $table->char('country_code',2);
            $table->string('email_prefix')->nullable();
            $table->string('regno_prefix')->nullable();
            $table->string('logo_url')->nullable();
            $table->integer('added_by_user_id')->unsigned();
            $table->boolean('is_verfied')->default(false);
            $table->char('color_foreground',7)->nullable();
            $table->char('color_background',7)->nullable();
            
            $table->string('last_contract_signed_date')->nullable();
            $table->string('next_contract_renewal_date')->nullable();
            $table->char('currency_code',3)->nullable();
            $table->date('retired_at')->nullable();
            $table->boolean('is_demo_account');
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
