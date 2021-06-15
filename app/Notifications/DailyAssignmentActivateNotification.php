<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ScheduledJob;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DailyAssignmentActivateNotification extends SthubAllowlistedUserNotification

{
    use Queueable;
    public $scheduled_job;
    public $classroom;
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
        $this->daily_assignment = $scheduled_job->job_body['daily_assignment'];
        //Log::info($this->daily_assignment);
        //Log::info($scheduled_job->job_body);
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
        $start_time = Carbon::createFromFormat('H:i:s',$this->daily_assignment['start_time'])->format('g:i A');
        $end_time = Carbon::createFromFormat('H:i:s',$this->daily_assignment['end_time'])->format('g:i A');
       // Log::info("DA Notification");
        return [
            'body'=>$notifiable->full_name."has scheduled a Daily Assignment for classroom ".$this->classroom->name." on ".$this->daily_assignment['attempt_date']." and it will be available from ".$start_time." to ".$end_time,
        ];
    }
}