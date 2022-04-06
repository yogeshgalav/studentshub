<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        $sql="INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
        (1, 'Engineering & Technology', 'technology'),
        (2, 'Business & Management', 'management'),
        (3, 'Healthcare', 'healthcare'),
        (4, 'Arts & Culture', 'arts'),
        (5, 'Science', 'science'),
        (6, 'Economics', 'economics'),
        (7, 'Education', 'education'),
        
        (8, 'Pharmacy', 'pharmacy'),
        (9, 'Journalism', 'journalism'),
        (10, 'Law & Humanity', 'humanity'),
        (11, 'Travel & Hospitality', 'hospitality'),
        (12, 'Design & Fashion', 'design'),
        (13, 'Computer Applications', 'computer');";

        DB::unprepared($sql);
    }
}
