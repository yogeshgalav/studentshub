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
        $sql="INSERT INTO `subjects` (`id`, `Subject_name`,`subject_url`, `parent_subject_id`) VALUES
        (1, 'Aggriculture', 'aggriculture', 0),
        (2, 'Arts & design', 'arts-and-design', 0),
        (3, 'Business', 'business', 0),
        (4, 'Computing & internet', 'computing-and-internet', 0),
        (5, 'Education', 'education', 0),
        (6, 'Energy', 'energy', 0),
        (7, 'Engineering', 'engineering', 0),
        (8, 'Environment', 'environment', 0),
        (9, 'Family', 'family', 0),
        (10, 'Finance & Economics', 'finance-and-economics', 0),
        (11, 'Food & Drink', 'food-and-drink', 0),
        (12, 'Games & Hobbies', 'games-and-hobbies', 0),
        (13, 'Goverment', 'goverment', 0),
        (14, 'Health', 'health', 0),
        (15, 'Home & Garden', 'home-and-garden', 0),
        (16, 'Humanities', 'humanities', 0),
        (17, 'Jobs & Carrier', 'jobs-and-carrier', 0),
        (18, 'Law', 'law', 0),
        (19, 'Literature', 'literature', 0),
        (20, 'Living things', 'living-things', 0),
        (21, 'Magazines & Journals', 'magazines-and-journals', 0),
        (22, 'Media & Entertainment', 'media-and-entertainment', 0),
        (23, 'Military', 'military', 0),
        (24, 'Music', 'music', 0),
        (25, 'News', 'news', 0),
        (26, 'People', 'people', 0),
        (27, 'Places', 'places', 0),
        (28, 'Politics', 'politics', 0),
        (29, 'Products and Technology', 'products-and-technology', 0),
        (30, 'Recreation', 'recreation', 0),
        (31, 'References', 'references', 0),
        (32, 'Regional', 'regional', 0),
        (33, 'Religion', 'religion', 0),
        (34, 'Science', 'science', 0),
        (35, 'Startup', 'startup', 0),
        (36, 'Social Science', 'social-science', 0),
        (37, 'Sports', 'sports', 0),
        (38, 'Transportation', 'transportation', 0),
        (39, 'Travel', 'travel', 0),
        (40, 'Weather', 'weather', 0),
        (41, 'Anatomy', 'anatomy', 0);
        (41, 'History', 'history', 0);
        ";
        DB::unprepared($sql);
    }
}
