<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_resources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('classroom_id')->unsigned();
            $table->string('link')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->string('type')->default('other');
            $table->string('access')->default('public');
            $table->string('description');
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
        Schema::dropIfExists('classroom_documents');
    }
}
