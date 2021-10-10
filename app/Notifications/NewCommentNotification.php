<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Channels\CustomDbChannel;

class NewCommentNotification extends Notification
{
    use Queueable;
    public $scheduled_job;
    public $msg_creater;
    public $classroom;
    public $url;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($scheduled_job)
    {
        $this->scheduled_job=$scheduled_job;
        $this->classroom=$scheduled_job->classroom;
        $this->msg_creater=$scheduled_job->scheduled_by_user;
        $this->url='/'.$this->scheduled_job->job_body['type'].'/'.$this->scheduled_job->job_body['id'];
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
        $body = $this->msg_creater->full_name." has commented on your" . $this->scheduled_job->job_body['type'] . ".";

        return [
            'scheduled_job_id'=>$this->scheduled_job->id,
            'user_id'=>$notifiable->id,
            'title'=>'New Comment.',
            'avatar_url'=>$this->msg_creater->avatar_url,
            'avatar_name'=>$this->msg_creater->full_name,
            'url'=>$this->url,
            'body' => $body,
        ];
    }
}
