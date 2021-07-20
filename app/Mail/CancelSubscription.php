<?php

namespace App\Mail;

use Auth;
use App\User;
use App\Models\Plan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelSubscription extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Plan $plan, User $user = null)
    {
        $this->plan = $plan;
        $this->user = $user ? $user : Auth::user();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.merchant.cancel-subscription')
                    ->with(['user' => $this->user, 'plan' => $this->plan]);
    }
}
