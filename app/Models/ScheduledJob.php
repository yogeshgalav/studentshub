<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\NewUserWelcomeNotification;
use App\Notifications\NewInstituteMemberNotification;
use App\Notifications\NewDoubtNotification;
use App\Notifications\NewPostNotification;
use App\Notifications\DailyAssignmentActivateNotification;
use App\Notifications\NewHomeworkNotification;
use App\Notifications\NewClassroomMessageNotification;
use App\Notifications\NewCommentNotification;
use App\Notifications\NewLikeNotification;
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
    public function toUser()
    {
        return $this->belongsTo(User::class, 'scheduled_for_user_id', 'id');
    }
    /**
     * @return BelongsTo
     */
    public function fromUser()
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
        return self::create([
            'run_at' => Carbon::now('UTC'),
            'job_type' => SendNotificationJob::class,
            'notification_class_name' => NewUserWelcomeNotification::class,
            'scheduled_by_user_id'=>$user->id,
            'scheduled_for_user_id'=>$user->id
        ]);
    }

    public static function scheduleNewInstituteMemberNotification($user){
        return self::create([
            'run_at' => Carbon::now('UTC'),
            'job_type' => SendNotificationJob::class,
            'notification_class_name' => NewInstituteMemberNotification::class,
            'scheduled_by_user_id'=>$user->id,
            'scheduled_for_user_id'=>$user->id
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
    public static function homeworkNotification($homework){
        return self::create([
            'run_at' => Carbon::now('UTC'),
            'job_type' => ClassroomNotificationJob::class,
            'job_body' => json_encode([
                'homework'=> $homework
            ]),
            'notification_class_name' => NewHomeworkNotification::class,
            'scheduled_by_user_id'=>Auth::id(),
            'classroom_id'=> $homework->classroom_id,
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
    public static function NewPostNotification($classroom, $post){
        return self::create([
            'run_at' => Carbon::now('UTC'),
            'job_type' => ClassmatesNotificationJob::class,
            'notification_class_name' => NewPostNotification::class,
            'scheduled_by_user_id'=>Auth::id(),
            'job_body'=>json_encode(['post_id'=>$post->id]),
            'classroom_id'=> $classroom->id,
        ]);
    }

    public static function NewLikeNotification(Like $like, $scheduled_for_user_id){
        return self::create([
            'run_at' => Carbon::now('UTC'),
            'job_type' => SendNotificationJob::class,
            'job_body' => json_encode(['like_id'=>$like->id]),
            'notification_class_name' => NewLikeNotification::class,
            'scheduled_by_user_id'=>Auth::id(),
            'scheduled_for_user_id'=> $scheduled_for_user_id,
        ]);
    }
    public static function NewCommentNotification(Comment $comment, $scheduled_for_user_id){
        return self::create([
            'run_at' => Carbon::now('UTC'),
            'job_type' => SendNotificationJob::class,
            'job_body' => json_encode(['comment_id'=>$comment->id]),
            'notification_class_name' => NewCommentNotification::class,
            'scheduled_by_user_id'=>Auth::id(),
            'scheduled_for_user_id'=>$scheduled_for_user_id,
        ]);
    }
    public function scheduleClassroomNotificationsForNewUser(User $user, Classroom $classroom) {
        $jobs = self::where('job_type', ClassroomNotificationJob::class)
        ->where('classroom_id', $classroom->id)
        ->get();
        foreach($jobs as $job){
            $classString = $job->notification_class_name;
            $notification = new $classString($job);
            $user->notify($notification);
        }
    }
}
