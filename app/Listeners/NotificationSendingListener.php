<?php

namespace App\Listeners;

use App\Notifications\SthubNotification;
use Illuminate\Notifications\Events\NotificationSending;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Class NotificationSendingListener.
 */
class NotificationSendingListener
{
    /**
     * @param NotificationSending $event
     *
     * @return bool
     */
    public function handle(NotificationSending $event)
    {
        // If it's not one of our notifications, proceed.
        // This way we don't break base Laravel or package behaviour.
        if (! $event->notification instanceof SthubNotification) {
            return true;
        }

        if (! method_exists($event->notification, 'shouldAbort')) {
            return true;
        }

        if ($event->notification->shouldAbort()) {
            $event->notification->getScheduledJob()->update([
                'completed_at' => Carbon::now('UTC'),
                'is_completed' => true,
            ]);

            return false;
        }

        return true;
    }
}
