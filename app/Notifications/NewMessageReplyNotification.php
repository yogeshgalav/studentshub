<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Channels\CustomDbChannel;

class NewMessageReplyNotification extends Notification
{
    use Queueable;
    public $scheduled_job;
    public $msg_creater;
    public $classroom;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($scheduled_job)
    {
        $this->scheduled_job=$scheduled_job;
        $this->msg_creater=User::find($scheduled_job->job_body['message_user_id']);
        $this->classroom=$scheduled_job->classroom;
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
        $body = "";
        if($notifiable->id===$this->msg_creater->id){
            $body = $this->msg_creater->full_name." has replied to your message in classroom " . $this->classrom->name . ".";
        } else {
            $body = $this->msg_creater->full_name." has also replied to message in classroom " . $this->classrom->name . ".";
        }
        return [
            'scheduled_job_id'=>$this->scheduled_job->id,
            'user_id'=>$notifiable->id,
            'title'=>'New Message Reply.',
            'avatar_url'=>$this->msg_creater->avatar_url,
            'avatar_name'=>$this->msg_creater->full_name,
            'url'=>"/classroom/".$this->classroom->id."/messages",
            'body' => $body,
        ];
    }
}
