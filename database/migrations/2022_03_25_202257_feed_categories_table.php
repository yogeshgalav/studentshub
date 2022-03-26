<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
        $sql="INSERT INTO `categories` (`name`, `category_url`) VALUES
        ('Business & Management', 'management'),
        ('Computer Applications', 'computer'),
        ('Economics', 'economics'),
        ('Engineering & Technology', 'technology'),
        ('Healthcare', 'healthcare'),
        ('Humanities', 'humanities'),
        ('Law', 'law'),
        ('Mass Communication', 'communication'),
        ('Science', 'science'),
        ('Sports', 'sports'),
        ('Travel & Hospitality', 'hospitality'),
        ('Visual & Performing Arts', 'arts');";

        DB::unprepared($sql);
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
