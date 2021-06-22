<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class CustomDbChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toDatabase($notifiable);

        Notification::create([
            'schedule_job_id'=>$message['schedule_job_id'],
            'title'=>$message['title'],
            'body'=>$message['body'],
            'avatar_url'=>$message['avatar_url'],
            'avatar_name'=>$message['avatar_name'],
            'user_id'=>$notifiable->id,
            'url'=>$message['url'],
        ]);
    }
}