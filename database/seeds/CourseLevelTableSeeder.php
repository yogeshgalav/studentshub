<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('course_levels')->insert([
            ['level' => '2','name' => 'Preparatory Stage'],
            ['level' => '3','name' => 'Middle Stage'],
            ['level' => '4','name' => 'Secoundary Stage'],
            ['level' => '5','name' => 'Bachelor'],
            ['level' => '6','name' => 'Master'],
            ['level' => '7','name' => 'PhD'],
        ]);
    }
}
