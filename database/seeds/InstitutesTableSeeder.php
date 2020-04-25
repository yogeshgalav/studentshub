<?php

use Illuminate\Database\Seeder;

class InstitutesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $sql="INSERT INTO `institutes` (`id`, `name`, `added_by_user_id`) VALUES
        (1, 'Poornima College of Engineering',1);";

        DB::unprepared($sql);
    }
}
