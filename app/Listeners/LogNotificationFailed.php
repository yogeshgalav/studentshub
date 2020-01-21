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
     * @param NotificationFailed  $event
     * @return void
     */
    public function handle(NotificationFailed $event)
    {
        Log::error('Event Failed...');
        Log::error(json_decode( json_encode($event), true));
    }
}