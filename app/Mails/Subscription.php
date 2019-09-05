<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Subscription extends SthubMailable
{
    use Queueable, SerializesModels;

    protected $commitment;
    protected $check_in_url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($commitment, $check_in_url)
    {
        $this->commitment = $commitment;
        $this->check_in_url = $check_in_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $client_name = $this->getMailFromName($this->commitment->conversationInstance->consultant_firm_id);
      $client_address = $this->getMailFromAddress($this->commitment->conversationInstance->consultant_firm_id);

      if ($this->commitment->first_checkin_notification_sent) {

        return $this->subject('Time to check in on your ' . $this->commitment->theme .  ' commitment')
                    ->view('mails.html.subsequent-checkIn')
                    ->text('mails.plain-text.subsequent-checkIn')
                    ->from($client_address, $client_name)
                    ->with(['commitment' => $this->commitment, 'check_in_url' => $this->check_in_url, 'client_name' => $client_name]);
      }

      $this->commitment->first_checkin_notification_sent = true;
      $this->commitment->save();

    return $this->subject('Time to check in on your ' . $this->commitment->theme .  ' commitment')
                  ->view('mails.html.checkInEmail')
                  ->text('mails.plain-text.checkInText')
                  ->from($client_address, $client_name)
                  ->with(['commitment' => $this->commitment, 'check_in_url' => $this->check_in_url, 'client_name' => $client_name]);
    }
}
