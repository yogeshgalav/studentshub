<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('course_url')->nullable(false)->change();
            $table->integer('category_id')->defaul(null)->nullable(true)->change();
        });

        $sql="INSERT INTO `courses` (`id`, `course_name`, `course_url`, `duration`, `eligibility`, `category_id`, `country_id`, `verified`, `alias`, `created_at`, `updated_at`) VALUES
        (1001, 'Preparatory Stage (3-5)', 'preparatory-stage', 'Three year', '', null, 'IN', 1, 'class', '2020-05-31 10:23:06', '2020-06-10 00:26:26'),
        (1002, 'Middle Stage (6-8)', 'middle-stage', 'Three year', 'Preparatory Stage', null, 'IN', 1, 'class', '2020-05-31 10:23:06', '2020-06-10 00:26:26'),
        (1003, 'Secoundary Stage (9-12)', 'secoundary-stage', 'Four year', 'Middle Stage', null, 'IN', 1, 'class', '2020-05-31 10:23:06', '2020-06-10 00:26:26');";
        DB::unprepared($sql);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
