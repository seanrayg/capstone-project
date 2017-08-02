<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use DB;

class SessionsController extends Controller
{
	public function create(Request $request){

		$this->validate(request(), [

			'CustomerEmail' => 'required|email',
			'ReservationCode' => 'required'

		]);

		$CustomerEmail = $request->input('CustomerEmail');
		$ReservationCode = $request->input('ReservationCode');

		// $LoginCode = str_random(30);

		// $boolHasEmail = DB::table('tblCustomer')->where('strCustEmail', $CustomerEmail)->update(['strConfirmationCode' => $LoginCode]);

		// if($boolHasEmail == 1){

		// 	Mail::send('emails.verify', ['LoginCode' => $LoginCode], function($message) use ($CustomerEmail){
	 //            $message->to($CustomerEmail);
	 //            $message->subject('Verify Login');
	 //        });

		// }

		return redirect('/Login');

	}

	//I made a comment
	//I made another comment

}
