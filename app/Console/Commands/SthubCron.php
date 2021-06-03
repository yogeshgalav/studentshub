<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ScheduledJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SthubCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sthub:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run unscheduled jobs.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        /***
         * Look through the scheduled jobs table and put the jobs
         * that are due to dispatched to the queue
         *
         * **/
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
        return 0;
    }
}
