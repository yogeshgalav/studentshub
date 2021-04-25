<?php
namespace Database\Seeders;

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
            ['level' => '2','name' => 'Preparatory Stage (3-5)'],
            ['level' => '3','name' => 'Middle Stage (6-8)'],
            ['level' => '4','name' => 'Secondary Stage (9-12)'],
            ['level' => '5','name' => 'Bachelor'],
            ['level' => '6','name' => 'Master'],
            ['level' => '7','name' => 'PhD'],
        ]);
    }
}
