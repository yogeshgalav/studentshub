<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Queue\Events\JobProcessed;
use App\Jobs\ScheduledJobInterface;
use App\Models\ScheduledJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Queue::after(function (JobProcessed $jobProcessed) {

            $payload = $jobProcessed->job->payload();
            $job_details = unserialize($payload['data']['command']);

            // Log::info('Queued Job Processed', [
            //     'job' => $jobProcessed,
            //     'payload' => $payload,
            // ]);

            if (! $job_details instanceof ScheduledJobInterface) {
                return;
            }

            if ($scheduled_job = ScheduledJob::find($job_details->scheduled_job->id)) {
                Log::info($job_details->job_cancelled ? 'Scheduled Job cancelled.' : 'Scheduled Job completed successfully.', [
                    'scheduled_job_id' => $scheduled_job->id,
                ]);

                $scheduled_job->completed_at     = Carbon::now();
                $scheduled_job->is_completed     = true;
                $scheduled_job->save();
            }
        });
    }
}
