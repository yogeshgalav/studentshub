<?php

use Illuminate\Database\Migrations\Migration;

class Alter6CategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $pr = DB::table('categories')->where('slug', 'performing-arts')->value('id');
        if(empty($pr)){
            DB::table('categories')->insert([
                'name'=>'Performing Arts',
                'slug'=>'performing-arts',
            ]);
        }

        $design = DB::table('categories')->where('slug', 'fine-arts')->value('id');
        DB::table('categories')->where('id', $design)
        ->update([
            'name' => 'Design Arts',
            'slug' => 'design-arts',
        ]);

        //update
        DB::table('courses')->where('course_name','LIKE','%fine%')->orWhere('course_name','LIKE','%design%')
        ->orWhere('course_name','LIKE','%painting%')
        ->orWhere('course_name','LIKE','%sculpture%')
        ->orWhere('course_name','LIKE','%fashion%')
        ->orWhere('course_name','LIKE','%architecture%')
        ->update([
            'category_id' => $design,
        ]);

        DB::table('courses')->where('course_name','LIKE','%dance%')->orWhere('course_name','LIKE','%music%')
        ->orWhere('course_name','LIKE','%drama%')
        ->orWhere('course_name','LIKE','%theater%')
        ->orWhere('course_name','LIKE','%performing%')
        ->update([
            'category_id' => $pr,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
