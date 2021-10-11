<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Channels\CustomDbChannel;
use App\Models\Like;

class NewLikeNotification extends Notification
{
    use Queueable;
    public $scheduled_job;
    public $like_creater;
    public $classroom;
    public $like;
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
        $this->like_creater=$scheduled_job->fromUser;
        $this->like=Like::find($this->scheduled_job->job_body['like_id']);
        $like_model_name = $this->like->getLikableTypeString();
        if('message'===$like_model_name){
            $this->url =config('url.site_url').'/messages';
        }else{
            $this->url=config('url.site_url').'/'.$like_model_name.'/'.$this->like->likable_id;
        }
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
        $body = $this->like_creater->full_name." has liked your " . $this->like->getLikableTypeString() . ".";

        return [
            'scheduled_job_id'=>$this->scheduled_job->id,
            'user_id'=>$notifiable->id,
            'title'=>'New Like.',
            'avatar_url'=>$this->like_creater->avatar_url,
            'avatar_name'=>$this->like_creater->full_name,
            'url'=>$this->url,
            'body' => $body,
        ];
    }
}
