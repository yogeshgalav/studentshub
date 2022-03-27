<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
class FeedCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // $sql="INSERT INTO `categories` (`name`, `slug`) VALUES
        // ('Business & Management', 'management'),
        // ('Computer Applications', 'computer'),
        // ('Economics', 'economics'),
        // ('Engineering & Technology', 'technology'),
        // ('Healthcare', 'healthcare'),
        // ('Humanities', 'humanities'),
        // ('Law', 'law'),
        // ('Mass Communication', 'communication'),
        // ('Science', 'science'),
        // ('Sports', 'sports'),
        // ('Travel & Hospitality', 'hospitality'),
        // ('Visual & Performing Arts', 'arts');";

        // DB::unprepared($sql);

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
        //update courses,doubts,posts 
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
