<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use DB;

class SessionsController extends Controller
{
	public function create(Request $request){

		// $this->validate(request(), [

		// 	'CustomerEmail' => 'required|email',
		// 	'TransactionID' => 'required'

		// ]);

		// $CustomerEmail = $request->input('CustomerEmail');
		// $ReservationCode = $request->input('ReservationCode');

		// $LoginCode = str_random(5);

		// $boolHasEmail = DB::table('tblCustomer')->where('strCustEmail', $CustomerEmail)->update(['strConfirmationCode' => $LoginCode]);

		// if($boolHasEmail == 1){

		// 	Mail::send('emails.verify', ['LoginCode' => $LoginCode], function($message) use ($CustomerEmail){
	 //            $message->to($CustomerEmail);
	 //            $message->subject('Verify Login');
	 //        });

	 //        echo "hehe";

		// }

		$CustomerEmail = $_POST['CustomerEmail'];
		$TransactionID = $_POST['TransactionID'];

		if($request->isMethod('POST')){

			$LoginCode = str_random(5);

			$boolHasEmail = DB::table('tblCustomer')->where('strCustEmail', $CustomerEmail)->update(['strConfirmationCode' => $LoginCode]);

			if($boolHasEmail == 1){

				Mail::send('emails.verify', ['LoginCode' => $LoginCode], function($message) use ($CustomerEmail){
		            $message->to($CustomerEmail);
		            $message->subject('Verify Login');
		        });

		        echo "hehe";

			}

		}

	}

}
