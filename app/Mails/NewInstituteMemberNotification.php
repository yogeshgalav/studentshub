<?php

namespace App\Mails;

use App\Models\User;

/***
 * Class NewInstituteMemberNotification
 * @package App\Mail
 */
class NewInstituteMemberNotification extends SthubMailable
{
    /***
     * @var
     */
    protected $password;
    protected $loginUrl;

    /**
     * Create a new message instance.
     *
     */
    public function __construct(string $password,string $loginUrl)
    {
        $this->password = $password;
        $this->loginUrl = $loginUrl;
    }

    /***
     * Build the message
     *
     * @return BuddyDeclineNotification
     */
    public function build()
    {
        return $this->subject('Welcome to Students Hub')
            ->view('mails.teacher.check-in')
            ->with([
                'password'=>$this->password,
                'theme'=>config('view.theme')
            ]);
    }
}
