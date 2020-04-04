<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $sql="INSERT INTO `categories` (`id`, `name`, `category_url`) VALUES
        (1, 'Engineering', 'engineering'),
        (2, 'Management', 'management'),
        (3, 'Medical', 'medical'),
        (4, 'Arts', 'arts'),
        (5, 'Science', 'science'),
        (6, 'Commerce', 'commerce'),
        (7, 'Education', 'education'),
        (8, 'Pharmacy', 'pharmacy'),
        (9, 'Journalism', 'journalism'),
        (10, 'Law', 'law'),
        (11, 'Hospitality', 'hospitality');";
    }
}
