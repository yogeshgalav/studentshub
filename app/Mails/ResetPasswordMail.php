<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PasswordReset $token)
    {
        $this->token=$token->token;
        $this->user=$token->user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@studentshub.in')
         ->view('mails.forgot-password')
         ->with('token', $this->token)
         ->with('url', config('app.url').'/reset-password?token='.$this->token)
         ->with('user', $this->user);
    }
}
