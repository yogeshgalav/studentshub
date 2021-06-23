<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ScheduledJob;
use Illuminate\Support\Facades\Log;
use App\Channels\CustomDbChannel;

class NewClassroomDoubtNotification extends Notification
{
    use Queueable;
    public $scheduled_job;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($scheduled_job)
    {
        $this->scheduled_job = $scheduled_job;
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
            'body' => $this->scheduled_job->user->full_name." asked a new doubt. You can answer it in Classroom Doubts."
        ];
    }
}
