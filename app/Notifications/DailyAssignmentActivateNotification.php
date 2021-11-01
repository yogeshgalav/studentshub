<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ScheduledJob;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Channels\CustomDbChannel;
use App\Models\DailyAssignment;

class DailyAssignmentActivateNotification extends Notification
{
    use Queueable;
    public $scheduled_job;
    public $classroom;
    public $teacher;
    public $daily_assignment;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($scheduled_job)
    {
        $this->scheduled_job = $scheduled_job;
        $this->classroom = $scheduled_job->classroom;
        $this->teacher = $scheduled_job->fromUser;
        $this->daily_assignment = DailyAssignment::find($scheduled_job->job_body['daily_assignment_id']);
    }
    /**
     * Add all logic here to determine whether or not this notification is still
     * valid.  It will run immediately before the notification is sent.
     *
     * Call $this->abortSending($reason) to log the job cancellation, and then
     * return boolean.
     *
     * @see NotificationSendingListener
     * @return bool
     */
    public function shouldAbort(): bool
    {
        if (empty($this->daily_assignment)) {
            return $this->abortSending('The daily_assignment was not found.');
        }
        if (empty($this->teacher)) {
            return $this->abortSending('The teacher was not found.');
        }
        if (empty($this->classroom)) {
            return $this->abortSending('The classroom was not found.');
        }
        return false;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [CustomDbChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $start_time = Carbon::createFromFormat('H:i:s',$this->daily_assignment['start_time'])->format('g:i A');
        $end_time = Carbon::createFromFormat('H:i:s',$this->daily_assignment['end_time'])->format('g:i A');
       // Log::info("DA Notification");
        return [
            'scheduled_job_id'=>$this->scheduled_job->id,
            'user_id'=>$notifiable->id,
            'title'=>'New Daily Assignment.',
            'avatar_url'=>$this->teacher->avatar_url,
            'avatar_name'=>$this->teacher->full_name,
            'url'=>"/classroom/".$this->classroom->id."/daily-assignment",
            'body'=>$this->teacher->full_name." has scheduled a Daily Assignment for classroom ".$this->classroom->name." on ".$this->daily_assignment['attempt_date']." and it will be available from ".$start_time." to ".$end_time,
        ];
    }
}