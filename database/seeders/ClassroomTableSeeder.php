<?php
namespace Database\Seeders;

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
        DB::table('classrooms')->insert([
            'classroom_join_id'=>'PPLBYAK',
            'name'=>'YOGESH',
            'teacher_user_id'=>1,
            'subject_id'=>1,
            'batch_id'=>1,
            'activated_unit'=>null,
        ]);

        DB::table('units')->insert([
            'classroom_id' => 1,
            'unit_no' => 0,
            'unit_name' => 'first lesson'
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
