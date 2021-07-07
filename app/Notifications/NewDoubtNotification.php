<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ScheduledJob;
use Illuminate\Support\Facades\Log;
use App\Channels\CustomDbChannel;

class NewDoubtNotification extends Notification
{
    use Queueable;
    public $scheduled_job;
    public $doubt;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($scheduled_job)
    {
        $this->scheduled_job = $scheduled_job;
        $this->doubt = $scheduled_job->job_body['doubt'];
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
        $rand=rand(60,100);
        $question_text = substr($this->doubt['question'],0,$rand) . '...';
        return [
            'scheduled_job_id'=>$this->scheduled_job->id,
            'user_id'=>$notifiable->id,
            'title'=>'New Doubt.',
            'avatar_url'=>$this->scheduled_job->user->avatar_url,
            'avatar_name'=>$this->scheduled_job->user->full_name,
            'url'=>"/doubt/".$this->doubt['id'],
            'body'=>$this->scheduled_job->user->full_name.' asked a doubt, "'.$question_text.'"',
        ];
    }
}
