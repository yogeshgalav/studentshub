<?php

namespace App\Listeners;

use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Support\Facades\Log;

class LogNotificationFailed
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param NotificationFailed $event
     * @return void
     */
    public function handle(NotificationFailed $event)
    {
        if (isset($event->channel) && 'twilio' === $event->channel) {
            if (isset($event->data['exception']) && 21610 === $event->data['exception']->getCode()) {
                Log::warning('SMS Not Send. Recipient is on Twilio Blacklist.', ['notifiable' => $event->notifiable, 'data' => $event->data]);

                return;
            }
            if (isset($event->data['exception']) && (21614 === $event->data['exception']->getCode() || 21211 === $event->data['exception']->getCode())) {
                Log::warning('SMS Not Send. Recipient Phone Number Not Valid', ['notifiable' => $event->notifiable, 'data' => $event->data]);

                return;
            }
        }

        Log::error('Failed to Send Notification', ['data' => $event->data, 'event' => $event]);
    }
}
