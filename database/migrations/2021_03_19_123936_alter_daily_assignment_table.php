<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterDailyAssignmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_assignments', function (Blueprint $table) {
            $table->enum('status',['draft','activated','deactivated','attempted','imported'])->default('draft');
        });
        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn('is_activated');
            $table->dropColumn('activated_at');
            $table->dropColumn('deactivated_at');
        });
        $sql = "UPDATE `daily_assignments` SET `status` = 'activated' where activated_at IS NOT NULL";
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
