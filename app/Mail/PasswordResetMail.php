<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $userName;
    public $expiresIn;

    public function __construct($code, $userName, $expiresIn = 15)
    {
        $this->code = $code;
        $this->userName = $userName;
        $this->expiresIn = $expiresIn;
    }

    public function build()
    {
        return $this->subject('Reset Password - Gateway to PTN')
            ->view('emails.password-reset');
    }
}
