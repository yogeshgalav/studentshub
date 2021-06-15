<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\NewUserWelcomeNotification;
use App\Notifications\NewInstituteMemberNotification;
use App\Notifications\NewClassroomDoubtNotification;
use App\Jobs\SendNotificationJob;
use Carbon\Carbon;
use Auth;
class ScheduledJob extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    public static $classroomJobs = [
        NewClassroomDoubtNotification::class,
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
    public static function newClassroomDoubtNotification($classroom_id){
        return self::create([
            'run_at' => Carbon::now('UTC'),
            'job_type' => SendNotificationJob::class,
            'notification_class_name' => NewClassroomDoubtNotification::class,
            'scheduled_by_user_id'=>Auth::id(),
            'classroom_id'=> $classroom_id
        ]);
    }
}
