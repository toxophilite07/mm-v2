<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeviceLoginConfirmation extends Mailable
{
    // use Queueable, SerializesModels;

    // public $user;
    // public $confirmationCode;

    // /**
    //  * Create a new message instance.
    //  *
    //  * @param  \App\Models\User  $user
    //  * @param  int  $confirmationCode
    //  * @return void
    //  */
    // public function __construct($user, $confirmationCode)
    // {
    //     $this->user = $user;
    //     $this->confirmationCode = $confirmationCode;
    // }

    // /**
    //  * Build the message.
    //  *
    //  * @return $this
    //  */
    // public function build()
    // {
    //     return $this->subject('Device Login Confirmation')
    //                 ->view('emails.device_login_confirmation');
    // }
}
