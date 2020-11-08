<?php

namespace App\Notifications;

use App\Commitment;
use Illuminate\Mail\Mailable;

class Subscription extends SthubAllowlistedUserNotification
{
    protected $commitment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Commitment $commitment)
    {
        parent::__construct();
        $this->commitment = $commitment;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return Mailable
     */
    public function toMail($notifiable)
    {
        $mail = new \App\Mail\Subscription($this->commitment, $this->getCheckInUrl('mail'));
            
        $mail->to($notifiable->preferredEmail);

        return $mail;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return Mailable
     */
    public function toTwilio($notifiable)
    {
            $content = "Hi {first_name},
            
Time to check in on your {theme} commitment, as part of the {session_name} learning session. " . $this->getAcceptanceUrl('sms');

        $content = str_replace('{first_name}', $this->commitment->user->first_name, $content);    
        $content = str_replace('{session_name}', $this->commitment->conversationInstance->title, $content);    
        $content = str_replace('{theme}', $this->commitment->theme, $content);    

        if ( ! $this->commitment->first_checkin_notification_sent ) {
            $this->commitment->first_checkin_notification_sent = true;
            $this->commitment->save();
        }
        
        $tw = new TwilioSmsMessage();
        $tw->content($content);
        $tw->from($this->getFromPhoneNumber());

        return $tw;
    }

    /***
     * Get the URL that the user will need to complete
     * their check-in.
     *
     * @param $method string Which notification metho is this link for? Used for analytics.
     *
     * @return string
     * @since 3.0.0
     */
    private function getCheckInUrl($method)
    {
        // Who's the client
        /** @var \App\Client $client */
        $client = $this->commitment->conversationInstance->client;
        $route = config('url.protocol') . $client->subdomain . '.' . config('url.basedomain') . '/daily-check-in/' . $this->commitment->id;
        $route .= '?notification_method=mail';

        return $route;
    }
}
