<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $userName;

    /**
     * Create a new message instance.
     */
    public function __construct($payment, $userName)
    {
        $this->payment = $payment;
        $this->userName = $userName;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Pembayaran Disetujui - Gateway to PTN')
            ->view('emails.payment-approved');
    }
}
