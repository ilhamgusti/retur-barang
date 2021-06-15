<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovalReject extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $emails;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emails)
    {
        $this->emails = $emails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.approval.reject',$this->emails);
    }
}
