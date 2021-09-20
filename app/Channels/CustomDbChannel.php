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

        \App\Models\Notification::create([
            'scheduled_job_id'=>$message['scheduled_job_id'],
            'title'=>$message['title'],
            'body'=>$message['body'],
            'avatar_url'=>$message['avatar_url'],
            'avatar_name'=>$message['avatar_name'],
            'user_id'=>$notifiable->id,
            'url'=>$message['url'],
        ]);

        if ($notifiable->fcm_token) {
            $this->sendAndroidNotification($notifiable, $message);
        }
    }

    public function sendAndroidNotification($notifiable, $message)
    {
        $accesstoken = env('FCM_KEY');
 
        $URL = 'https://fcm.googleapis.com/fcm/send';
     
     
            $post_data = '{
                "to" : "' . $notifiable->fcm_token . '",
                "data" : {
                  "body" : "' . $message['body'] . '",
                  "title" : "' . $message['title'] . '",
                  "message" : "' . $message['body'] . '",
                },
                "notification" : {
                     "body" : "' . $message['body'] . '",
                     "title" : "' . $message['title'] . '",
                     "message" : "' . $message['body'] . '",
                    "icon" : "new",
                    "sound" : "slack"
                    },
     
              }';
            // print_r($post_data);die;
     
        $crl = curl_init();
     
        $headr = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: ' . $accesstoken;
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
     
        curl_setopt($crl, CURLOPT_URL, $URL);
        curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
     
        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
     
        return curl_exec($crl);
    }
}