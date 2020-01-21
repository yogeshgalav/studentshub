<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SthubJobInterface implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $job_body;
    protected $job_id;
    protected $job_cancelled = false;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($job_id, $job_body)
    {
        $this->job_id = $job_id;
        if ('' !== $job_body) {
            $job_body = json_decode($job_body);
        }

        $this->job_body = $job_body;
    }

    protected function cancel($reason, $error = false)
    {
        $this->job_cancelled = true;

        if ($error) {
            Log::error('Job #' . $this->job_id . ' - ' . $reason);
            $this->fail($reason);
        } else {
            Log::info('Skipped Job #' . $this->job_id . ' - ' . $reason);
        }

        return $this->cleanup();
    }

    protected function cleanup()
    {
        $job = \App\Queue::findOrFail($this->job_id);

        if ($this->job_cancelled) {
            Log::info('Job #' . $job->id . ' (' . $job->job_type . ') cancelled.');
            return false;
        } else {
            Log::info('Job #' . $job->id . ' (' . $job->job_type . ') has completed successfully.');
        }


        $job->completed_at = Carbon::now();
        $job->is_completed = true;
        $job->save();

        return true;
    }
}
