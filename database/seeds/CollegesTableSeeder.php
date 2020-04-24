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
        $sql="INSERT INTO `institutes` (`id`, `name`,) VALUES
        (1, 'Poornima College of Engineering');";

        DB::unprepared($sql);
    }
}
