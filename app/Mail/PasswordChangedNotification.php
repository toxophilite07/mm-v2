<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordChangedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Password Changed Successfully')
                    ->view('emails.password_changed')
                    ->with([
                        'userName' => $this->user->first_name . ' ' . $this->user->last_name,
                    ]);
    }
}
