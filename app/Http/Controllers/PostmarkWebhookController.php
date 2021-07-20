<?php

namespace App\Http\Controllers;

use App\Mail\InviteEmployee;
use App\Models\EmailNotification;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PostmarkWebhookController
{
    public function handleWebhook(Request $request)
    {
    	$input = $request->input();
    	$emailNotification = EmailNotification::where('message_id', $input['MessageID'])->first();
    	if($emailNotification) {
    		if($input['RecordType'] == 'Open') {
    			$emailNotification->is_opened = true;
    		} else {
    			$emailNotification->status = $input['RecordType'];
    		}
    		$emailNotification->save();
    	}
    	return response()->json([], 200);
    }

    public function testNotification()
    {
        return (new InviteEmployee(Auth::user()->merchant, Auth::user(), '12345567'))->render();
        // Mail::to('zyree.lyric@intrees.org')->send(new WelcomeEmail(Auth::user()));
    }
}