<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropColumn('expected_students');
            $table->dropColumn('classroom_duration');
            $table->dropColumn('estimated_start_date');
            $table->dropColumn('estimated_end_date');
            $table->string('meet_link')->nullable();
        }); 
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
