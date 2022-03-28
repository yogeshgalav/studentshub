<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;

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
        Category::where('id',10)->update([
            'name'=>'Law',
            'slug'=>'law',
        ]); 
        Category::where('id',9)->update([
            'name'=>'Mass Communication',
            'slug'=>'communication',
        ]); 
        //change education to humanities,
        Category::where('id',7)->update([
            'name'=>'Humanities',
            'slug'=>'humanities',
        ]);
        //chhange arts&culture to visual and performing then add design to it
        Category::where('id',4)->update([
            'name'=>'Performing Arts',
            'slug'=>'performing-arts',
        ]);
        //add design
        Category::where('id',12)->update([
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
