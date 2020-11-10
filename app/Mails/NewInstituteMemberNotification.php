<?php

namespace App\Mail;

use App\Models\User;

/***
 * Class NewInstituteMemberNotification
 * @package App\Mail
 */
class NewInstituteMemberNotification extends ActionableMailable
{
    /***
     * @var
     */
    /**
     * Create a new message instance.
     *
     */
    public function __construct(string $password,string $inviteNewBuddyUrl)
    {
        $this->participant = $participant;
        $this->inviteNewBuddyUrl = $inviteNewBuddyUrl;
        $this->setCommitment = $commitment;
    }

    /***
     * Build the message
     *
     * @return BuddyDeclineNotification
     */
    public function build()
    {
        return $this->subject('Welcome to Students Hub')
            ->view('mails.html.teacher.check-in')
            ->with([
                'password'=>$this->password,
                'theme'=>config('view.theme')
            ]);
    }
}
