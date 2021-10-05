<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Unit;
use App\Models\ClassroomUnit;

class CreateClassroomUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_units', function (Blueprint $table) {
            $table->id();
            $table->integer('unit_id')->unsigned();
            $table->integer('classroom_id')->unsigned();
            $table->integer('unit_order');
            $table->timestamps();
        });

        foreach(Unit::get() as $unit){
            $classroom_unit = new ClassroomUnit;
            $classroom_unit->classroom_id = $unit->classroom_id;
            $classroom_unit->unit_order = $unit->unit_no;
            $classroom_unit->save();
        }

        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn('classroom_id');
            $table->dropColumn('unit_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classroom_units');
    }
}
