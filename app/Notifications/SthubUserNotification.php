<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SthubUserNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {

        $via = [];

        switch ($notifiable->preferred_contact_method) {
            case 'email':
                $via = $this->via_email($notifiable);
                break;
            case 'sms':
                $via = $this->via_twilio($notifiable);
                break;
            default:
                Log::error('Cannot determine notification delivery channel: ' . $notifiable->preferred_contact_method);
                $via = [];
        }

        return $via;
    }

    /***
     * Determine if a user, who as chosen to be contacted by email,
     * can receive notifications.  Includes a block for not sending
     * to production users in test/dev environments.
     *
     * @since 3.0.0
     * @return array
     */
    public function via_email($notifiable)
    {
        if (! in_array(config('app.env'), ['production'])) {
            $whitelist_emails = config('constants.whitelist_emails');
            $whitelist_email_domains = config('constants.whitelist_email_domains');

            $emails = $notifiable->emails()->get();

            if ('maildev' === config('mail.host') || 'log' === config('mail.driver')) {
                return ['mail'];
            }

            foreach ($emails as $user_email) {
                $email = $user_email->email;
                $email_domain=explode('@', $email)[1];
                if (!in_array($email_domain, $whitelist_email_domains) && !in_array($email, $whitelist_emails)) {
                    Log::info('Cannot send mail to: '.$email. '. The address is not on the allowed list for this environment.');
                    return [];
                }
            }
        }

        return ['mail'];
    }

    /***
     * Determine if a user, who as chosen to be contacted by SMS,
     * can receive notifications.  Includes a block for not sending
     * to production users in test/dev environments.
     *
     * $notifable Notifiable    The user, or other object with the Notifiable
     *                          trait, who will receive this SMS message.
     * 
     * @since 3.0.0
     * @return array
     */
    public function via_twilio($notifiable)
    {
        if (! in_array(config('app.env'), ['production'])) {
            $blocked = true;
            $whitelist_phone_sms = config('constants.whitelist_phone_sms');
        
            if ( $notifiable instanceof \App\User ) {
                Log::debug('Looking for user....');
                foreach ($notifiable->phones()->get() as $phone) {
                    if (in_array($phone->phone, $whitelist_phone_sms)) {
                        Log::info('Cleared to send notification to ' . $notifiable->preferredPhone);
                        $blocked = false;
                        break;
                    }
                }
            }

            if ( $notifiable instanceof \App\Buddy ) {
                if (in_array($notifiable->contact_address, $whitelist_phone_sms)) {
                    Log::info('Cleared to send notification to ' . $notifiable->contact_address);
                    $blocked = false;
                }
            }

            if ($blocked) {
                Log::info('Notification blocked, phone number not in the allowed sandbox array');
                return [];
            }
        }

        return [\NotificationChannels\Twilio\TwilioChannel::class];
    }

    /***
     * Returns the phone number that Twilio will use as the sender.
     * 
     * @return string
     * @since 3.0.0
     */
    public function getFromPhoneNumber() {
        return '+17787704577';
    }

}
