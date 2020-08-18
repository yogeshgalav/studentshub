<?php

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
        DB::table('batches')->insert([
            'start_year'=>2014,
            'end_year'=>2018,
            'course_id'=>32,
            'institute_id'=>1,
        ]);

        DB::table('batch_students')->insert([
            'batch_id' => 1,
            'student_id'=>1,
            'is_preffered'=>true
            ]);

        DB::table('students')->insert([
            'user_id' => '1',
            'prefferred_batch' => '1',
            'prefferred_category' => '1',
            'unique_college_id' => '1',
        ]);
    }
}
