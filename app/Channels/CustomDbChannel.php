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
        $accesstoken = 'key='.env('FCM_KEY');
 
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
     
        $curl = curl_init();
     
        $headr = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: ' . $accesstoken;
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
     
        curl_setopt($curl, CURLOPT_URL, $URL);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headr);
     
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
     
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            Log::critical('Firebase api call failure cURL Error #:' . $err);
        } else {
            Log::info('Android notification sent to '.$notifiable->full_name.' #:' . $notifiable->id);
        }
        
        return true;
    }
}