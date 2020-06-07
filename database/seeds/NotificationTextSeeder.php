<?php

use Illuminate\Database\Seeder;

class NotificationTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\NotificationText::create([
            'notification_type'=>'App\Notifications\BatchNewUserNotification',
            'notification_text'=>'notifications.BatchNewUser'
            ]);
        \App\Models\NotificationText::create([
            'notification_type'=>'App\Notifications\NewUserWelcomeNotification',
            'notification_text'=>'notifications.NewUserWelcome'
        ]);
    }
}
