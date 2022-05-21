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
        $p_arts = DB::table('categories')->where('slug', 'performing-arts')->value('id');
        $humanities = DB::table('categories')->where('slug', 'humanities')->value('id');
        DB::table('courses')->where('category_id', $p_arts)
        ->update([
            'category_id' => $humanities,
        ]);

        DB::table('categories')->where('slug', 'performing-arts')->delete();
        $visual = DB::table('categories')->where('slug', 'visual-arts')->value('id');
        DB::table('categories')->where('id', $visual)
        ->update([
            'name' => 'Fine Arts',
            'slug' => 'fine-arts',
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
