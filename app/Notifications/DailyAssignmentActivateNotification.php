<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ScheduledJob;

class DailyAssignmentActivateNotification extends SthubAllowlistedUserNotification

{
    use Queueable;
    public $scheduled_job;
    public $user_name;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($scheduled_job)
    {
        $this->scheduled_job = $scheduled_job;
       // $this->user_id = $user_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
       // Log::info("DA Notification");
        return [
            'body'=>$notifiable->full_name."has scheduled a Daily Assignment for classroom ".$notifiable,
        ];
    }
}