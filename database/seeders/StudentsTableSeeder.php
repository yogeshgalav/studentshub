<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('students')->insert([
            'user_id' => '1',
            'course_id'=>'1',
            'institute_id'=>'1',
            'is_preferred'=>1,
            'unique_college_id' => '1',
        ]);
    }
}
