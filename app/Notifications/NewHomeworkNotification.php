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
use App\Channels\ParentSmsChannel;

class NewHomeworkNotification extends Notification
{
    use Queueable;
    public $scheduled_job;
    public $classroom;
    public $teacher;
    public $homework;
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
        $this->homework = Homework::find($scheduled_job->job_body['homework_id']);
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
        if (empty($this->homework)) {
            return $this->abortSending('The homework was not found.');
        }
        if (empty($this->classroom)) {
            return $this->abortSending('The classroom was not found.');
        }
        if (empty($this->teacher)) {
            return $this->abortSending('The teacher was not found.');
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
        $channels =[CustomDbChannel::class];
        $parent = $notifiable->parents()->first();
        if($parent){
            array_push($channels,ParentSmsChannel::class);
        }
        return $channels;
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
        return [
            'scheduled_job_id'=>$this->scheduled_job->id,
            'user_id'=>$notifiable->id,
            'title'=>'New Homework.',
            'avatar_url'=>$this->teacher->avatar_url,
            'avatar_name'=>$this->teacher->full_name,
            'url'=>"/classroom/".$this->classroom->id."/homework/" . $this->homework['id'],
            'body'=>$this->teacher->full_name." has created a new Homework for subject ".$this->classroom->subject->subject_name." with submission date ".$this->homework['submission_date'],
        ];
    }

    public function toParentSms($notifiable)
    {
        $parent = $notifiable->parents()->first();
        $parent_user = $parent->parent;
        return [
            'institute_id'=>$this->classroom->institute_id,
            'parent_user_id'=>$parent_user->id,
            'body'=>'Hi '.$parent_user->first_name.", ".$this->teacher->full_name." has created a new Homework for subject ".$this->classroom->subject->subject_name." with submission date ".$this->homework['submission_date']."\nThanks and Regards,\n" . $this->classroom->institute->name,
        ];
    }
}