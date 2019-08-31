<?php

namespace App\Jobs;

use App\Commitment;
use App\Facades\Sthub;
use App\Notifications\Subscription;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

/***
 * Class SubscriptionNotification
 * @package App\Jobs
 * @since 3.0.0
 */
class SubscriptionNotification extends SthubJobInterface
{

    public function __construct($job_id, $job_body)
    {
        parent::__construct($job_id, $job_body);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $job = \App\Queue::findOrFail($this->job_id);
        $job_body = [];
        if ('' !== $job->job_body) {
            $job_body = json_decode($job->job_body);
        }
        $this->job_body = $job_body;

        // if (! isset($this->job_body->id)) {
        //     return $this->cancel('SubscriptionNotification: No Commitment ID found in job_body. ' . $this->job_body, true);
        // }

        // Retrieve the commitment
        /** @var Commitment $commitment */
        // $commitment = \App\Commitment::find($this->job_body->id);

        // if (null === $commitment) {
        //     return $this->cancel('Cannot find commitment #' . $this->job_body->id . ' to run job SubscriptionNotification ' . $this->job_id, false);
        // }

        // if ($commitment->isEnded) {
        //     return $this->cancel('Not processing job because commitment is already closed ' . $this->job_id, false);
        // }

        // Send the notification
        $notify = $commitment->user->notify(new Subscription($commitment));

        // Cleanup
        return $this->cleanup();
    }

    public function tags()
    {
        $job = \App\Queue::findOrFail($this->job_id);
        return ['notificationType:Subscription', 'commitment:'.$job->commitment_id, 'user:' . $job->user_id, 'conversationInstance:' . $job->conversation_instance_id];
    }
}
