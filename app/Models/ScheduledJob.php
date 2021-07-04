<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\NewUserWelcomeNotification;
use App\Notifications\NewInstituteMemberNotification;
use App\Notifications\NewDoubtNotification;
use App\Notifications\NewClassroomResourceNotification;
use App\Notifications\DailyAssignmentActivateNotification;
use App\Notifications\NewClassroomMessageNotification;
use App\Notifications\NewMessageReplyNotification;
use App\Jobs\SendNotificationJob;
use App\Jobs\ClassroomNotificationJob;
use App\Jobs\ClassmatesNotificationJob;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Log;

class ScheduledJob extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];

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
    public static function newDoubtNotification($doubt){
        return self::create([
            'run_at' => Carbon::now('UTC'),
            'job_body' => json_encode(['doubt'=>$doubt]),
            'job_type' => ClassmatesNotificationJob::class,
            'notification_class_name' => NewDoubtNotification::class,
            'scheduled_by_user_id'=>Auth::id(),
        ]);
    }

    public static function dailyAssignmentActivateNotification($daily_assignment){
        return self::create([
            'run_at' => Carbon::now('UTC'),
            'job_type' => ClassroomNotificationJob::class,
            'job_body' => json_encode([
                'daily_assignment'=> $daily_assignment
            ]),
            'notification_class_name' => DailyAssignmentActivateNotification::class,
            'scheduled_by_user_id'=>Auth::id(),
            'classroom_id'=> $daily_assignment->classroom_id
        ]);
    }
    public static function newClassroomMessageNotification($classroom){
        return self::create([
            'run_at' => Carbon::now('UTC'),
            'job_type' => ClassroomNotificationJob::class,
            'notification_class_name' => NewClassroomMessageNotification::class,
            'scheduled_by_user_id'=>Auth::id(),
            'classroom_id'=> $classroom->id,
        ]);
    }
    public static function newClassroomResourceNotification($classroom){
        return self::create([
            'run_at' => Carbon::now('UTC'),
            'job_type' => ClassroomNotificationJob::class,
            'notification_class_name' => NewClassroomResourceNotification::class,
            'scheduled_by_user_id'=>Auth::id(),
            'classroom_id'=> $classroom->id,
        ]);
    }
    public static function newClassroomReplyMessageNotification($classroom, $user){
        return self::create([
            'run_at' => Carbon::now('UTC'),
            'job_type' => SendNotificationJob::class,
            'job_type' => json_encode(['message_user_id'=>Auth::id()]),
            'notification_class_name' => NewMessageReplyNotification::class,
            'scheduled_by_user_id'=>$user->id,
            'classroom_id'=> $classroom->id,
        ]);
    }
}
