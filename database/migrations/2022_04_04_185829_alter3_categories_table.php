<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class Alter3CategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (Schema::hasColumn('categories', 'category_url'))
        {
            Schema::table('categories', function (Blueprint $table)
            {
                $table->dropColumn('category_url');
            });
        }
        DB::table('categories')->insert([
            'name'=>'Sports',
            'slug'=>'sports',
        ]);
        $social_id = DB::table('categories')->insertGetId([
            'name'=>'Social Studies',
            'slug'=>'social-studies',
        ]);
        DB::table('categories')->where('id',10)->update([
            'name'=>'Law & Humanity',
            'slug'=>'law',
            'parent_category_id'=>$social_id,
        ]); 

        DB::table('categories')->where('id',8)->update([
            'name'=>'Pharmacy/Paramedical Science',
            'parent_category_id'=>3,
        ]);
        //change law to social studies,
        //history, geography, religious education, scoiology, psychology, goverment and politics ,,Law
      
        DB::table('categories')->where('id',9)->update([
            'name'=>'Mass Communication',
            'slug'=>'mass-communication',
        ]);

        //change education to gk,
        DB::table('categories')->where('id',7)->update([
            'name'=>'GK and Education',
            'slug'=>'education'
        ]);

        DB::table('categories')->where('id',6)->update([
            'name'=>'Economics and Finance',
        ]);
        //update arts to performing arts
        DB::table('categories')->where('id',4)->update([
            'name'=>'Performing Arts',
            'slug'=>'performing-arts',
        ]);
        //update design
        DB::table('categories')->where('id',12)->update([
            'name'=>'Visual Arts',
            'slug'=>'visual-arts',
        ]);
        //delete general knowledge
        Course::where('category_id',14)->update([
            'category_id'=>7,
        ]);
        DB::table('categories')->where('id',14)->delete();

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
