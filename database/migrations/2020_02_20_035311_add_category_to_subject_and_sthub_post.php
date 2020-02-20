<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryToSubjectAndSthubPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sthub_post', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->nullable();
        });
        Schema::table('subject', function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subject_and_sthub_post', function (Blueprint $table) {
            //
        });
    }
}
