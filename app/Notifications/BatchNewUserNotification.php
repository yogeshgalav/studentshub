<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Log;
use App\Models\User;
use App\Models\Batch;
use App\Models\student;

class BatchNewUserNotification extends Notification
{
    use Queueable;

    protected $message='';
    protected $batch;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user,Batch $batch)
    {
        $this->batch=$batch;
        $students=Student::whereDate('created_at', '=', date('Y-m-d'))->get();
        $total_new_users=$students->count();
        $new_users=[];
        for($i=0;$i<$total_new_users;$i++){
            $new_users[$i]=$students[$i]->first_name;
            if($i=3){
            break;
            }
        }
        $message=implode(', ',$new_users);
        if($total_new_users>3){
            $message .= ' and '.$total_new_users.' others';
        }
        $message .= ' have joined your batch.Show them your knowledge.';

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
    {Log::debug('tomail');
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
    {Log::debug('todatabase');
        return [
            'batch_id'=>$this->batch->id
        ];
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
