<?php

namespace App\Jobs;

use App\Models\ScheduledJob;
use App\Models\ClassroomUser;

/***
 * Class ClassroomNotificationJob
 * @package App\Jobs
 */
class ClassroomNotificationJob extends ScheduledJobInterface
{
    /**
     * Execute the job.
     *
     * @return false
     */
    public function handle()
    {
        $classString = $this->scheduled_job->notification_class_name;
        $classroom_users = ClassroomUser::where('classroom_users.classroom_id', $this->scheduled_job->classroom_id)
        ->get();

        foreach($classroom_users as $c_user){
            if($this->scheduled_job->scheduled_by_user_id === $student->user_id){
                continue;
            }
            $notification = new $classString($this->scheduled_job);
            $c_user->user->notify($notification);
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
