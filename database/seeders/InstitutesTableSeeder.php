<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        $sql="INSERT INTO `institutes` (`id`, `name`,`address`,`place_id`,`description`,`added_by_user_id`) VALUES
        (1, 'Poornima College of Engineering','ISI-6, RIICO Institutional Area, Sitapura, Jaipur, Rajasthan, India','ChIJ____j38cbDkRjbsnsfWl5X4','Poornima College of Engineering, ISI-6, RIICO Institutional Area, Sitapura, Jaipur, Rajasthan, India',1);";
        DB::unprepared($sql);
    }
}
