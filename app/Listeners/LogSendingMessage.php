<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class LogSendingMessage
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
     * @param  MessageSending  $event
     * @return void
     */
    public function handle(MessageSending $event)
    {

        if ('local'===env('APP_ENV')) {
            $whitelist_emails=config('constants.whitelist_emails');
            $whitelist_email_domains=config('constants.whitelist_email_domains');
            $emails = array_keys($event->message->getTo());
            foreach ($emails as $email) {
                $email_domain=explode('@', $email)[1];
                if (!in_array($email_domain, $whitelist_email_domains) && !in_array($email, $whitelist_emails)) {
                    Log::info('Email sending restricted to '.$email.' with data '.$event->message->getBody());
                    return false;
                }
            }
        }
    }
}
