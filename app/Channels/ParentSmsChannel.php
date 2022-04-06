<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Sms;

class ParentSmsChannel
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
        $message = $notification->toParentSms($notifiable);

        $phone_no = User::find($message['parent_user_id'])->phone_no;
        $field = array(
            "sender_id" => "FSTSMS",
            "language" => "english",
            "message" => $message['body'],
            "route" => "q",
            "numbers" => $phone_no,
            );
            
            $curl = curl_init();
            
            curl_setopt_array($curl, [
              CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => json_encode($field),
              CURLOPT_HTTPHEADER => [
                "authorization: ".config("auth.sms_key"),
                "cache-control: no-cache",
                "accept: */*",
                "content-type: application/json"
              ],
            ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            \Log::critical('sms api call failure cURL Error #:' . $err);
        }else{
          Sms::create([
            'institute_id'=>$message['institute_id'],
            'parent_user_id'=>$message['parent_user_id'],
          ]);
        }

        return true;
    }
}