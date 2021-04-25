<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('country')->insert([
            ['country_code' => 'IN','name' => 'India'],
            ['country_code' => 'AU','name' => 'Australia'],
            ['country_code' => 'CA','name' => 'Canada'],
            ['country_code' => 'UK','name' => 'United Kingdom'],
            ['country_code' => 'NZ','name' => 'New Zealand'],
            ['country_code' => 'US','name' => 'United States of America']
        ]);
    }
}
