<?php

namespace App\Jobs;

use App\Models\ScheduledJob;

/***
 * Class SendNotificationJob
 * @package App\Jobs
 */
class SendNotificationJob extends ScheduledJobInterface
{
    /**
     * Execute the job.
     *
     * @return false
     */
    public function handle()
    {
        $classString = $this->scheduled_job->notification_class_name;

        //dont send notification if it was send by notifyNow
        $dont_send = [
            \App\Notifications\ResetPasswordNotification::class,
        ];

        if (in_array($classString, $dont_send)) {
            return false;
        }

        $notification = new $classString($this->scheduled_job);
        $this->scheduled_job->user->notify($notification);

        return true;
    }

    /**
     * @return array
     */
    public function tags(): array
    {
        return parent::tags();
    }
}
