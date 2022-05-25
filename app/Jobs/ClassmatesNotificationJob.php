<?php

namespace App\Jobs;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ScheduledJob;
use App\Models\ClassroomUser;

/***
 * Class ClassmatesNotificationJob
 * @package App\Jobs
 */
class ClassmatesNotificationJob extends ScheduledJobInterface
{
    /**
     * Execute the job.
     *
     * @return false
     */
    public function handle()
    {
        $classString = $this->scheduled_job->notification_class_name;
        $user = User::find($this->scheduled_job->scheduled_by_user_id);
        $institute_users = User::where('preferred_institute_id', $user->preferred_institute_id)
        ->where('id', '!=', $user->id)
        ->get();

        foreach($institute_users as $in_user){
            $notification = new $classString($this->scheduled_job);
            $in_user->notify($notification);
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
