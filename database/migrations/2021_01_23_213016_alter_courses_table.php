<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        $category_id = DB::table('categories')->insertGetId([
            'name'=>'General Knowledge',
            'category_url'=>'gk'
        ]);
        DB::table('courses')->whereIn('id',['1001','1002','1003'])
        ->update([
            'category_id'=>$category_id,
        ]);
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
