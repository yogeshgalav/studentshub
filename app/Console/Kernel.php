<?php

namespace App\Console;

use App\Models\ScheduledJob;
use Illuminate\Support\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        /***
         * Look through the scheduled jobs table and put the jobs
         * that are due to dispatched to the queue
         *
         * **/
        $schedule->call(function () {
            $this->queueScheduledJobs();
        })->everyMinute()->name('sthub_notifications');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
        /**
     * @throws Exception
     */
    public function queueScheduledJobs()
    {
        // Check for all jobs that are due to be run
        $jobs = ScheduledJob::where('run_at', '<=', Carbon::now('utc'))
                            ->whereNull('sent_to_queue_at')
                            ->where('is_completed', '=', 0)
                            ->get();

        foreach ($jobs as $job) {
            Log::info('Dispatching scheduled job to queue', [
                'scheduled_job_id' => $job->id,
            ]);

            $job_to_queue = new $job->job_type($job);
            $job_to_queue->dispatch($job);

            $job->sent_to_queue_at = Carbon::now('utc');
            $job->save();
        }
    }
}
