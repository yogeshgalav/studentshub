<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Channels\CustomDbChannel;
use App\Models\Post;

class NewPostNotification extends Notification
{
    use Queueable;
    public $scheduled_job;
    public $user;
    public $classroom;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($scheduled_job)
    {
        $this->scheduled_job=$scheduled_job;
        $this->user=$scheduled_job->fromUser;
        $this->classroom=$scheduled_job->classroom;
        $this->post=Post::find($scheduled_job->job_body['post_id']);
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
        if (empty($this->post)) {
            return $this->abortSending('The post was not found');
        }
        if (empty($this->user)) {
            return $this->abortSending('The user was not found');
        }
        if (empty($this->classroom)) {
            return $this->abortSending('The classroom was not found');
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
        return [
            'scheduled_job_id'=>$this->scheduled_job->id,
            'user_id'=>$notifiable->id,
            'title'=>'New Post.',
            'avatar_url'=>$this->user->avatar_url,
            'avatar_name'=>$this->user->full_name,
            'url'=>"/post/".$this->post->id,
            'body' => $this->user->full_name." has added a new post for the subject " . $this->classroom->subject->subject_name . ".",
        ];
    }
}
