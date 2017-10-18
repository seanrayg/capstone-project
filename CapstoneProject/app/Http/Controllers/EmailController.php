<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;

class EmailController extends Controller
{
    
	public function sendWarningEmail(Request $request) {

		$CustomerEmail = $request->input('CustomerEmail');
		$EmailMessage = $request->input('EmailMessage');

		Mail::send('emails.warning', ['EmailMessage' => $EmailMessage], function($message) use ($CustomerEmail){
            $message->to($CustomerEmail);
            $message->subject('Reservation Reminder');
        });

        return \Redirect::back();

	}

}
