<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class RegistrationOtpMail extends Mailable
{
    use SerializesModels;
    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        $htmlContent = '<p>Your email verification code is: <strong>' . $this->otp . '</strong></p>';
        // Send as plain text without using a view
        return $this->subject('Your Registration OTP Code')
            ->html($htmlContent);
    }
}
