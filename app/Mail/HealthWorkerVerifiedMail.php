<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HealthWorkerVerifiedMail extends Mailable
{
    use SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Your Account Has Been Verified')
                    ->view('emails.health_worker_verified')
                    ->with([
                        'userName' => $this->user->first_name . ' ' . $this->user->last_name,
                    ]);
    }
}