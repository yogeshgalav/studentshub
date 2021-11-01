<?php

namespace App\Listeners;

use App\Models\NotificationLog;
use App\Notifications\SthubNotification;
use App\Channels\CustomDbChannel;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Twilio\TwilioChannel;

/**
 * Listens for notifications that were sent.  They
 * may or may not be successful.
 */
class NotificationSentListener
{
    /**
     * Handle the event.
     *
     * @param  NotificationSent $event
     *
     * @return void
     */
    public function handle(NotificationSent $event)
    {
        if (! $event->notification instanceof SthubNotification) {
            return;
        }

        Log::info($event->channel);
        $scheduled_job = $event->notification->getScheduledJob();
        // Log that the notification was sent
        switch ($event->channel) {
            case CustomDbChannel::class:
                $success_message = 'Notification Sent on database notificaton';
                Log::debug($success_message, [
                    'scheduled_job_id' => $scheduled_job->id,
                ]);
                break;
            case MailChannel::class:
                $success_message = 'Notification Sent by E-Mail';
                Log::debug($success_message, [
                    'scheduled_job_id' => $scheduled_job->id,
                ]);
                // NotificationLog::create([
                //     'notification_id' => $event->notification->id,
                //     'notification_channel'=> MailChannel::class,
                //     'notification_recipient' => $event->notifiable,
                //     'notification_class_name' => $scheduled_job->notification_class_name,
                //     'status' => 'sent',
                //     'user_id' => $scheduled_job->user_id,
                //     'locale_code' => app('actionable')->swapLanguageWithAssumedLocale(app()->getLocale()),
                //     'client_id' => $scheduled_job->client_id,
                //     'buddy_id' => $scheduled_job->buddy_id,
                //     'conversation_instance_id' => $scheduled_job->conversation_instance_id,
                //     'commitment' => $scheduled_job->commitment_id,
                // ]);

                break;

            case TwilioChannel::class:
                $success_message = $event->response->sid;

                Log::debug($success_message, [
                    'scheduled_job_id' => $scheduled_job->id,
                    'message_sid' => $event->response->sid ?? null,
                ]);

                // NotificationLog::updateOrCreate([
                //     'twilio_sid'=> $event->response->sid,
                // ], [
                //     'notification_id' => $event->notification->id,
                //     'notification_channel'=> TwilioChannel::class,
                //     'notification_recipient' => $event->notifiable,
                //     'notification_class_name' => $scheduled_job->notification_class_name,
                //     'status' => 'sent',
                //     'twilio_sid'=> $event->response->sid,
                //     'user_id' => $scheduled_job->user_id,
                //     'locale_code' => app('actionable')->swapLanguageWithAssumedLocale(app()->getLocale()),
                //     'client_id' => $scheduled_job->client_id,
                //     'buddy_id' => $scheduled_job->buddy_id,
                //     'conversation_instance_id' => $scheduled_job->client_id,
                //     'commitment' => $scheduled_job->commitment_id,
                // ]);
                break;
        }

        $scheduled_job->response = json_encode($success_message);
        $scheduled_job->save();
    }
}
