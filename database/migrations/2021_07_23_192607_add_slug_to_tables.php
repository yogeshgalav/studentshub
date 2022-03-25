<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->renameColumn('course_url', 'slug');
        });
        Schema::table('subjects', function (Blueprint $table) {
            $table->renameColumn('subject_url', 'slug');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug');
        });
        Schema::table('institutes', function (Blueprint $table) {
            $table->string('slug');
        });
        Schema::table('doubts', function (Blueprint $table) {
            $table->string('slug');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
}
