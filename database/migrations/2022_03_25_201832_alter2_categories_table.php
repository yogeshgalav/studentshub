<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Alter2CategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('category_url')->rename('slug');
            //jobs and course will be added accordingly for better enrichment
            $table->integer('parent_category_id')->unsigned()->nullable();
        });
        
        //change law  to law,
        DB::table('categories')->where('id',10)->update([
            'name'=>'Law & Humanity',
            'slug'=>'law',
        ]); 
        DB::table('categories')->where('id',9)->update([
            'name'=>'Mass Communication',
            'slug'=>'communication',
        ]); 
        //change education to humanities,
        DB::table('categories')->where('id',7)->update([
            'name'=>'Humanities',
            'slug'=>'humanities',
        ]);
        //change arts&culture to visual and performing then add design to it
        DB::table('categories')->where('id',4)->update([
            'name'=>'Performing Arts',
            'slug'=>'performing-arts',
        ]);
        //add design
        DB::table('categories')->where('id',12)->update([
            'name'=>'Visual Arts',
            'slug'=>'visual-arts',
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
