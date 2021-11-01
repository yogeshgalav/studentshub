<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Log;
use App\Models\User;
use App\Models\Batch;
use App\Models\student;
use Illuminate\Notifications\Notification;

class NewInstituteMemberNotification extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
        return false;
    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $password = \Sthub::generatePassword(8);
        $mail = new \App\Mails\NewInstituteMemberNotification($password, $this->getPrimaryLink($notifiable, MailChannel::class));
        $mail->to($notifiable->email)
            ->from(config('mail.from.address'), 'StudentsHUB');

        return $mail;
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

    public function getPrimaryLink($notifiable, $channel){
        return  'http://studentshub.in/login';
    }
}
