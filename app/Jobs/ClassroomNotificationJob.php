<?php

namespace App\Jobs;

use App\Models\ScheduledJob;

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
        $students = DB::table('classroom_students as cs')
        ->where('cs.classroom_id', $this->scheduled_job->classroom_id)
        ->leftJoin('students as st', 'cs.student_id', 'st.id')
        ->leftJoin('users as us', 'st.user_id', 'us.id')
        ->select('us.id as user_id')
        ->groupBy('us.id')
        ->get();

        foreach($students as $student){
            $notification = new $classString($this->scheduled_job);
            $user = User::find($student->user_id);
            $user->notify($notification);
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
