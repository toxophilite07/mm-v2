<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeminineVerifiedMail extends Mailable
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Your Female User Account Has Been Verified')
                    ->view('emails.feminine_verified')
                    ->with([
                        'userName' => $this->user->first_name . ' ' . $this->user->last_name,
                    ]);
    }
}
