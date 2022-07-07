<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;
    private $verificationCode;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('elzatouna@elzatouna.com', 'مجتمع الامتحانات')
            ->subject("تفعيل البريد الالكتروني")
            ->view('email-verification', ["verificationCode" => $this->verificationCode]);

    }
}
