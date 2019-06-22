<?php

use Illuminate\Database\Seeder;
use Laravel\Passport\ClientRepository;
use App\Models\User;

class UserTableSeeder extends Seeder
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
            null, 'Application Front-End', '/'
        );

        // Create Shawn's Staff Account
        $user = factory(User::class)->create([
            'first_name' => 'Yogesh',
            'last_name' => 'Galav',
            'full_name' => 'Yogeh Galav',
            'email' => 'yogesh@gmail.com',
            'phone' => '8003345821',
            // 'timezone' => 'UTC+0',
            'country_code' => 'IN',
            'locale_code' => 'EN',
            'password' => bcrypt($password = '123456'),
        ]);


        // // Create "Cam Consultant" Consultant Account
        // $user2 = factory(\App\User::class)->create([
        //     'first_name' => 'Cam',
        //     'last_name' => 'Consultant',
        //     'full_name' => 'Cam Consultant',
        //     'timezone' => 'UTC+0',
        //     'locale' => 'en_US',
        //     'is_actionable_staff' => false,
        //     'password' => bcrypt($password = '123456'),
        // ]);

        // $user2->addEmail('consultant@actionable.co', true);
        // $user2->addEmail('cam.consultant@gmail.com', false);
        // $user2->addPhone('+16137997880',true);

        // $consultant_user = factory(\App\ConsultantFirmUser::class)->create(['user_id'=>$user2->id]);
        
        // // Create Client Account
        // $user3 = factory(\App\User::class)->create([
        //     'first_name' => 'Yogesh',
        //     'last_name' => 'Galav',
        //     'full_name' => 'Yogesh Galav',
        //     'timezone' => 'UTC+0',
        //     'locale' => 'en_US',
        //     'is_actionable_staff' => false,
        //     'password' => bcrypt($password = '123456'),
        // ]);

        // $user3->addEmail('mr.yogesh.galav@gmail.com', false);
        // $user3->addPhone('+918003345821',true);

        // $client = factory(\App\Client::class)->create(['name'=>'Galav Consultancy service','subdomain'=>'mr-yogesh-galav']);
        // $client_user = factory(\App\ClientUser::class)->create(['client_id'=>$client->id,'user_id'=>$user3->id]);
        
    }
}
