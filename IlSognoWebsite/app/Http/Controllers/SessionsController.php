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

		$ConfirmationCode = str_random(30);

		$boolHasEmail = DB::table('tblCustomer')->where('strCustEmail', $CustomerEmail)->update(['strConfirmationCode' => $ConfirmationCode]);

		if($boolHasEmail == 1){

			//I wrote a code here!

		}

	}
}
