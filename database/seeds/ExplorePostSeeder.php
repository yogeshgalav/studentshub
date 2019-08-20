<?php

use Illuminate\Database\Seeder;

class ExplorePostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            factory(\App\Models\ExplorePagePost::class,3)->create(['page_section'=>'ExploreTopPost']);
            factory(\App\Models\ExplorePagePost::class,6)->create(['page_section'=>'HomePostContainer']);
            factory(\App\Models\ExplorePagePost::class,3)->create(['page_section'=>'ExploreSidebar']);
            factory(\App\Models\ExplorePagePost::class,3)->create(['page_section'=>'ExploreBottomPost']);
    }
}
