<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    // Constructor
    public function __construct($user)
    {
        $this->user = $user;
    }

    // Build the message
    public function build()
    {
        return $this->view('emails.admin_verification')
                    ->with([
                        'userName' => $this->user->first_name,
                    ])
                    ->subject('Account Awaiting Admin Verification');
    }
}
