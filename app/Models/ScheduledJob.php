<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\NewUserWelcomeNotification;
use App\Notifications\NewInstituteMemberNotification;
use App\Notifications\DailyAssignmentActivateNotification;
use App\Jobs\SendNotificationJob;
use Carbon\Carbon;
use Auth;

class ScheduledJob extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    public static $classroomJobs = [
        DailyAssignmentActivateNotification::class,
        // NewClassroomMessageNotification::class,
        // NewClassroomResourceNotification::class,
        // NewClassroomDoubtNotification::class,
    ];
     /***
     * Cast fields to native data types
     *
     * @var array
     */
    protected $casts = [
        'is_completed' => 'boolean',
    ];

    protected $dates = [
        'run_at',
        'completed_at',
        'sent_to_queue_at',
    ];

    
    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'scheduled_by_user_id', 'id');
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id', 'id');
    }
    public function getJobBodyAttribute($value)
    {
        return json_decode($value, true);
    }

    public static function scheduleNewUserNotification($user){
        $job = self::create([
            'run_at' => Carbon::now('UTC'),
            'job_type' => SendNotificationJob::class,
            'notification_class_name' => NewUserWelcomeNotification::class,
            'user_id'=>$user->id
        ]);
        // $user->notify(new NewUserWelcomeNotification);
        return $job;
    }

    public static function scheduleNewInstituteMemberNotification($user){
        return self::create([
            'run_at' => Carbon::now('UTC'),
            'job_type' => SendNotificationJob::class,
            'notification_class_name' => NewInstituteMemberNotification::class,
            'user_id'=>$user->id
        ]);
    }
    public static function dailyAssignmentActivateNotification($daily_assignment){
        return self::create([
            'run_at' => Carbon::now('UTC'),
            'job_type' => SendNotificationJob::class,
            'job_body' => json_encode([
                'daily_assignment'=> $daily_assignment
            ]),
            'notification_class_name' => DailyAssignmentActivateNotification::class,
            'scheduled_by_user_id'=>Auth::id(),
            'classroom_id'=> $daily_assignment->classroom_id
        ]);
    }
}
