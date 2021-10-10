<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Log;
use App\Channels\CustomDbChannel;
use App\Models\User;
use App\Models\Batch;
use App\Models\student;
use App\Models\ScheduledJob;
use Carbon\Carbon;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;
use Illuminate\Notifications\Notification;

class NewUserWelcomeNotification extends Notification
{
    use Queueable;

    protected $text;
    public $scheduled_job;

        /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($scheduled_job)
    {
        $this->scheduled_job = $scheduled_job;
        $this->text="Welcome to Student'sHUB. You can now connect with your Institute, Teachers and Students.";
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
     * Get the web push representation of the notification.
     *
     * @param  mixed  $notifiable
     * @param  mixed  $notification
     * @return \Illuminate\Notifications\Messages\DatabaseMessage
     */
    // public function toWebPush($notifiable, $notification)
    // {
    //     return (new WebPushMessage)
    //         ->title('Hi '.$notifiable->full_name.',')
    //         ->icon('/notification-icon.png')
    //         ->body($this->text)
    //         ->action('View app', 'view_app')
    //         ->data(['id' => $notification->id]);
    // }

    // /**
    //  * Get the mail representation of the notification.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return \Illuminate\Notifications\Messages\MailMessage
    //  */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.');
    // }

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
            'title'=>'Hi '.$notifiable->full_name.',',
            'avatar_url'=>$notifiable->avatar_url,
            'avatar_name'=>$notifiable->full_name,
            'url'=>'/profile/'.$notifiable->id,
            'body' => "Hi ".$notifiable->first_name.", ".$this->text,
        ];
    }
}
