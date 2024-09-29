<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordCode extends Mailable
{
    use SerializesModels;

    public $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function build()
    {
        $htmlContent = '<p>Your password reset code is: <strong>' . $this->code . '</strong></p>';

        return $this->subject('Your Password Reset Code')
            ->html($htmlContent);
    }

}
