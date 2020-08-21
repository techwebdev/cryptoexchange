<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyAdminTransferSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $transfer;
    public $user;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transfer,$to)
    {
        $this->transfer = $transfer;
        $this->user = $to;
        $this->subject = "Transfer Success of ".$transfer->ref_no;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->markdown('emails.admin.success-transfer');
    }
}
