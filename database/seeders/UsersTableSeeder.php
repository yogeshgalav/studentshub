<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Passport\ClientRepository;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Password Grant Client
        $clientRepository = new ClientRepository();
        $this->client = $clientRepository->createPasswordGrantClient(
            null, 'sthub', '/'
        );

        $sql = "INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES    
        (1, 'Yogesh  Galav',  'yogesh@gmail.com', '$2y$10\$xZQrSvgNjXC23GpIU5WD.e2ZlMhTGn4JbpL6N6xXcZ9XW3sI9mKPO', 'AlIXWxYOU5t7k50MAbYQO1sHDuUZVeEgAIHz3xddL7FkRVrB2KNO0Vmw02tK', '2018-03-26 21:45:18', '2018-03-26 21:45:18'),
        (2, 'Yogesh Galav',  'mr.yogesh.galav@gmail.com', '$2y$10\$LOCIEFW7eCsjkPGxTlbgdO7xek.Pfu5crIyAugAklHmFxI8HspQam', '4Zi1FVuaryTGSOglos4Sn2EIIMt55869r09g4ftnFtkOvi8epmiE17iYE8br', '2018-05-05 14:03:51', '2018-07-09 23:30:25')
        ;";
        
        DB::unprepared($sql);
        DB::table('teachers')->insert([
            'user_id'=>1,
            'institute_id'=> 1,
        ]);
        DB::table('institute_users')->insert([
            'institute_id'=> 1,
            'user_id'=> 1
        ]);
    }

    
}
