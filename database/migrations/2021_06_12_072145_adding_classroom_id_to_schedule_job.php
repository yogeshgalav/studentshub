<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddingClassroomIdToScheduleJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scheduled_jobs', function (Blueprint $table) {
            $table->integer('classroom_id')->unsigned()->nullable();
            $table->renameColumn('user_id', 'scheduled_by_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedule_job', function (Blueprint $table) {
            //
        });
    }
}
