<?php

namespace App\Jobs;

use App\Models\ScheduledJob;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

/***
 * Class ScheduledJobInterface
 *
 * @property object job_body
 */
class ScheduledJobInterface implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $job_body;

    public ScheduledJob $scheduled_job;

    public bool $job_cancelled = false;

    /***
     * @param ScheduledJob $scheduled_job
     */
    public function __construct(ScheduledJob $scheduled_job)
    {
        $this->scheduled_job = $scheduled_job;
        $this->scheduled_job->load(['user', 'buddy', 'commitment']);
        $this->job_body = (empty($scheduled_job->job_body)) ? [] : $scheduled_job->job_body;
    }

    /***
     * @param string $reason
     * @param boolean $error
     * @param array|null $context
     *
     * @return void
     * @throws Throwable
     */
    protected function cancel(string $reason, bool $error = false, array $context = null)
    {
        $this->job_cancelled = true;

        if ($error) {
            Log::error('Job Failed', [
                'scheduled_job_id' => isset($this->job_body['queue_id']) ? $this->job_body['queue_id'] : null,
                'reason'           => $reason,
                'context'          => $context,
            ]);
            $this->failed(new Exception($reason));

            return;
        }

        Log::info('Job Skipped', [
            'scheduled_job_id' => isset($this->job_body['queue_id']) ? $this->job_body['queue_id'] : null,
            'reason' => $reason,
            'context' => $context,
        ]);

        $this->scheduled_job->update([
            'is_completed' => 1,
            'response' => json_encode($reason),
        ]);
    }

    /**
     * Process an exception that caused the job to fail.
     *
     * @param Throwable $e
     *
     * @return void
     * @throws Throwable
     */
    public function failed(Throwable $e)
    {
        if (!$this->job_cancelled) {
            Log::error('Job Failed', ['job' => $this, 'error' => $e]);
            throw $e;
        }
    }

    /**
     * Default tags to render in Horizon.
     *
     * @return array
     */
    protected function tags(): array
    {
        $attributes = $this->scheduled_job->only([
            'client_id',
            'commitment_id',
            'conversation_instance_id',
            'id',
            'job_type',
            'notification_class_name',
            'user_id',
        ]);

        $tags = [];

        foreach ($attributes as $key => $value) {
            if (null === $value) {
                continue;
            }
            array_push($tags, "$key:$value");
        }

        return $tags;
    }
}
