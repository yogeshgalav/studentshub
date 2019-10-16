<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(CountryTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(CoursesTableSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ExplorePostSeeder::class);
        // $this->call(ConsultantFirmTableSeeder::class);
        // $this->call(ClientTableSeeder::class);
        // $this->call(ConversationInstanceTableSeeder::class);
    }
}
