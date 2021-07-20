<?php

namespace App\Listeners;

use App\Models\EmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class MessageSentListener
{
    public function handle(MessageSent $event)
    {
        $body = $event->message->getBody();
        $subject = $event->message->getSubject();
        $to_emails = array_keys($event->message->getTo());
        $postmark_id = $event->message->getHeaders()->get('x-pm-message-id')->getValue();
        foreach ($to_emails as $to_email) {
	        EmailNotification::create([
	        	'message_id' => $postmark_id,
	        	'to_email'   => $to_email,
	        	'subject'    => $subject,
	        	'status'     => null
	        ]);
        }
	}
}