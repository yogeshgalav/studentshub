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
        // $this->call(ConsultantFirmTableSeeder::class);
        // $this->call(ClientTableSeeder::class);
        // $this->call(ConversationInstanceTableSeeder::class);
    }
}
