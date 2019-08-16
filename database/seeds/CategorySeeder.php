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
        $sql="INSERT INTO `subjects` (`id`, `Subject_name`, `parent_subject_id`) VALUES
        (1, 'Aggriculture', 0),
        (2, 'Arts & design', 0),
        (3, 'Business', 0),
        (4, 'Computing & internet', 0),
        (5, 'Education', 0),
        (6, 'Energy', 0),
        (7, 'Engineering', 0),
        (8, 'Environment', 0),
        (9, 'Family', 0),
        (10, 'Finance & Economics', 0),
        (11, 'Food & Drink', 0),
        (12, 'Games & Hobbies', 0),
        (13, 'Goverment', 0),
        (14, 'Health', 0),
        (15, 'Home & Garden', 0),
        (16, 'Humanities', 0),
        (17, 'Jobs & Carrier', 0),
        (18, 'Law', 0),
        (19, 'Literature', 0),
        (20, 'Living things', 0),
        (21, 'Magazines & Journals', 0),
        (22, 'Media & Entertainment', 0),
        (23, 'Military', 0),
        (24, 'Music', 0),
        (25, 'News', 0),
        (26, 'People', 0),
        (27, 'Places', 0),
        (28, 'Politics', 0),
        (29, 'Products and Technology', 0),
        (30, 'Recreation', 0),
        (31, 'References', 0),
        (32, 'Regional', 0),
        (33, 'Religion', 0),
        (34, 'Science', 0),
        (35, 'Shopping', 0),
        (36, 'Social Science', 0),
        (37, 'Sports', 0),
        (38, 'Transportation', 0),
        (39, 'Travel', 0),
        (40, 'Weather', 0);
        ";
        DB::unprepared($sql);
    }
}
