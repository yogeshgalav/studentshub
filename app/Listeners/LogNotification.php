<?php

namespace App\Listeners;

use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Log;

/**
 * Listens for notifications that were sent.  They
 * may or may not be successful.
 * 
 * @since 3.0.0
 */
class LogNotification
{
    /**
     * Create the event listener.
     *
     * @since 3.0.0
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderShipped  $event
     * @return void
     * @since 3.0.0
     */
    public function handle(NotificationSent $event)
    {
        //Log::debug($event->channel);
        //Log::debug($event->notifiable);
        //Log::debug($event->response);
        //Log::debug(print_r($event->notification, true));

        if ( 'NotificationChannels\Twilio\TwilioChannel' === $event->channel ) {
            Log::debug('SMS Sent. Twilio Message ID: ' . $event->response->sid);
        } else {
            Log::debug('Notification Sent via "' . $event->channel . '"');            
        }

    }
}