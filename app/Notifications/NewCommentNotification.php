<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Channels\CustomDbChannel;
use App\Models\Comment;

class NewCommentNotification extends SthubNotification
{
    use Queueable;
    public $scheduled_job;
    public $msg_creater;
    public $classroom;
    public $comment;
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
        $this->msg_creater=$scheduled_job->fromUser;
        $this->comment=Comment::find($this->scheduled_job->job_body['comment_id']);
        
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
        if (empty($this->comment)) {
            return $this->abortSending('The comment was deleted');
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
        $com_model_name = $this->comment->getCommentableTypeString();
        if('message'===$com_model_name){
            $this->url =config('url.site_url').'/messages';
        }else{
            $this->url=config('url.site_url').'/'.$com_model_name.'/'.$this->comment->commentable_id;
        }
        $body = $this->msg_creater->full_name." has commented on your " . $this->comment->getCommentableTypeString() . ".";

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
