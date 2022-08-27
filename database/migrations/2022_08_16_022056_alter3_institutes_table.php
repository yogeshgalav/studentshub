<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Alter3InstitutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('institutes', function (Blueprint $table) {
            $table->renameColumn('timeline', 'banner_url');
            $table->renameColumn('profile_url', 'logo_url');
            $table->dropColumn('total_students');
            $table->double('latitude', 2, 6)->nullable();
            $table->double('longitude', 2, 6)->nullable();
            $table->integer('admin_user_id')->nullable();
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
