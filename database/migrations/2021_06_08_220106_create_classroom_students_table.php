<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateClassroomStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_students', function (Blueprint $table) {
            $table->id();
            $table->integer('classroom_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->timestamps();
        });
        foreach(DB::table('classroom_users')->get() as $item)
        {
            $student = Student::where('user_id',$item->user_id)->first();
            DB::table('classroom_students')->insert(
                array(
                       'classroom_id'   =>  $item->classroom_id,
                       'student_id' => $student->id
                )
           );    
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classroom_students');
    }
}
