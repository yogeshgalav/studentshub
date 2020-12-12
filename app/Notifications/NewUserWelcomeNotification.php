<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Log;
use App\Models\User;
use App\Models\Batch;
use App\Models\student;
use App\Models\ScheduledJob;
use Carbon\Carbon;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;
class NewUserWelcomeNotification extends SthubAllowlistedUserNotification
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
        parent::__construct();

        $this->scheduled_job = $scheduled_job;
        $this->text="Welcome to Student'sHUB. You can now check your interest field in Profile section.";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast', WebPushChannel::class];
    }

    /**
     * Get the web push representation of the notification.
     *
     * @param  mixed  $notifiable
     * @param  mixed  $notification
     * @return \Illuminate\Notifications\Messages\DatabaseMessage
     */
    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Hi '.$notifiable->full_name.',')
            ->icon('/notification-icon.png')
            ->body($this->text)
            ->action('View app', 'view_app')
            ->data(['id' => $notification->id]);
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
                    ->line('The introduction to the notification.');
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
            'title'=>'Hi '.$notifiable->full_name.',',
            'body'=>$this->text,
            'user_id'=>$notifiable->id,
            'url'=>'/profile/'.$notifiable->id,
            'urlName'=>'profile',
            'urlId'=>$notifiable->id,
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'title'=>'Hi '.$notifiable->full_name.',',
            'body'=>$this->text,
            'user_id'=>$notifiable->id,
            'url'=>'/profile/'.$notifiable->id,
            'urlName'=>'profile',
            'urlId'=>$notifiable->id,
        ];
    }
}
