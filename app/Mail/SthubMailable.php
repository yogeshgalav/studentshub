<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SthubMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($commitment)
    {
    }

    /***
     * Determines the "from" line in the email, appending
     * the ACP Firm's name to the Platform Name.
     *
     * @param $consultant_firm_id int The ID of the consultant firm
     * @since 3.0.0
     * @return array
     */
    protected function getMailFromAddress($consultant_firm_id)
    {
        return config('mail.from');
    }

    /***
     * Determines the "from" line in the email, appending
     * the ACP Firm's name to the Platform Name.
     *
     * @param $consultant_firm_id int The ID of the consultant firm
     * @since 3.0.0
     * @return array
     */
    protected function getMailFromName($consultant_firm_id)
    {

        $firm = \App\ConsultantFirm::findOrFail($consultant_firm_id);

        return 'Actionable via ' . $firm->name;
    }
}
