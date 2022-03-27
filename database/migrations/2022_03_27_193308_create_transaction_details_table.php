<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('transaction_id')->nullable();
            $table->string('for_plan');
            $table->char('currency',3)->default('INR');
            $table->decimal('amount');
            $table->decimal('tax');
            $table->smallInteger('discount')->default(0);
            $table->decimal('totalAmount');
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
        Schema::dropIfExists('transaction_details');
    }
}
