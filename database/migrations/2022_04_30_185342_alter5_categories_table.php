<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Alter5CategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $id= DB::table('categories')->where('slug','social-studies')->value('id');
        DB::table('categories')->where('id',$id)
        ->update([
            'name'=>'Humanities',
            'slug'=>'humanities',
        ]);
        DB::table('categories')->where('slug','literature')
        ->update([
            'parent_category_id'=>$id,
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
