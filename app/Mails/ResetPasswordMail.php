<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;
    protected $request;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PasswordReset $token, Request $request)
    {
        $this->token=$token->token;
        $this->user=$token->user;
        $this->request=$request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $log = new Log();
        $url = parse_url(URL::current());
        return $this->from('notifications@actionable.co')
         ->view('mails.forgot-password')
         ->with('token', $this->token)
         ->with('host', $url['scheme'] . '://' . $url['host'])
         ->with('user', $this->user);
    }
}
