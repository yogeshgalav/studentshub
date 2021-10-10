<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Classroom;
use App\Models\ScheduledJob;
use App\Jobs\ClassroomNotificationJob;

/***
 * Class NewUserNotificationJob
 * @package App\Jobs
 */
class NewUserNotificationJob extends ShouldQueue
{
    private User $user;
    private Classroom $classroom;

    public function __construct(User $user,Classroom $classroom)
    {
        $this->user = $user;
        $this->classroom = $classroom;
    }
    /**
     * Execute the job.
     *
     * @return false
     */
    public function handle()
    {
        $jobs = ScheduledJob::where('job_type', ClassroomNotificationJob::class)
        ->where('classroom_id', $this->classroom->id)
        ->get();
        foreach($jobs as $job){
            $classString = $job->notification_class_name;
            $notification = new $classString($job);
            $this->user->notify($notification);
        }

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
