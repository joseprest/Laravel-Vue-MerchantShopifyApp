<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteEmployee extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $merchant;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($merchant, $user, $password)
    {
        $this->merchant = $merchant;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.merchant.employee-access');
    }
}
