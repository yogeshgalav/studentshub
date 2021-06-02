<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class AddCategoryIdToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $sql1 = "ALTER TABLE posts ADD category_id  int(10) unsigned ";
            DB::unprepared($sql1);
            $sql = "update posts set category_id = (select category_id from subjects where subjects.id = posts.subject_id)";
            DB::unprepared($sql);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->integer('subject_id')->nullable()->change();
            //$table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
