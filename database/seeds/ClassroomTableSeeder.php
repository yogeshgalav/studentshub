<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $time=\Carbon\Carbon::now()->toDateTimeString();
        DB::table('teachers')->insert([
            'user_id'=>1
        ]);

        DB::table('classrooms')->insert([
            'classroom_live_id'=>'PPLBYAK',
            'name'=>'YOGESH',
            'teacher_id'=>1,
            'subject_id'=>1,
            'course_id'=>1,
            'expected_students'=>60,
            'activated_unit'=>null,
            'classroom_duration'=>6,
            'estimated_start_date'=>$time,
            'estimated_end_date'=>$time
        ]);

        DB::table('units')->insert([
            'classroom_id' => 1,
            'unit_no' => 0,
            'unit_name' => 'first lesson',
            'activated_at'=>$time,
            'deactivated_at'=>$time
            ]);

        // DB::table('topics')->insert([
        //     'unit_id' => 1,
        //     'topic_name' => 'topic1',
        //     'post_type' => 'article',
        // ]);

        // DB::table('topic_answers')->insert([
        //     'topic_id' => 1,
        //     'user_id' => 1,
        //     'post_id' =>1,
        // ]);

    }
}
