<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use DB;

class SessionsController extends Controller
{
	public function create(Request $request){

		if($request->isMethod('POST')){

			$CustomerEmail = $_POST['CustomerEmail'];
			$TransactionID = $_POST['TransactionID'];

			$LoginCode = str_random(5);

			try {

				$user = DB::table('tblCustomer as a')
							->join('tblReservationDetail as b', 'a.strCustomerID', '=', 'b.strResDCustomerID')
							->select('a.strCustEmail', 'b.strReservationCode')
							->where('a.strCustEmail', '=', $CustomerEmail)
							->first();

			} catch(\Illuminate\Database\QueryException $ex){ 
				return $ex->getMessage();
			}

			if(count($user)){

				if($TransactionID == $user->strReservationCode){

					DB::table('tblCustomer')
						->where('strCustEmail', $CustomerEmail)
						->update(['strConfirmationCode' => $LoginCode]);

					// Mail::send('emails.verify', ['LoginCode' => $LoginCode], function($message) use ($CustomerEmail){
			  //           $message->to($CustomerEmail);
			  //           $message->subject('Verify Login');
			  //       });

			        echo 1;

				}else{

					echo 2;

				}

			}else{

				echo 2;

			}

		}//End of Request POST

	}//End of Create Method

	public function VerifyCode(Request $request){

		if($request->isMethod('POST')){

			$CustomerEmail = $_POST['CustomerEmail'];
			$VerificationCode = $_POST['VerificationCode'];

			try {

				$data = DB::table('tblCustomer')
							->select('strConfirmationCode',
									 'strCustomerID')
							->where('strCustEmail', $CustomerEmail)
							->first();

			} catch(\Illuminate\Database\QueryException $ex){ 
				return $ex->getMessage();
			}
			$ReservationID = DB::table('tblReservationDetail')
							 ->where('strResDCustomerID', '=', $data->strCustomerID)
							 ->pluck('strReservationID')
							 ->first();

			if($data->strConfirmationCode == $VerificationCode) {

				echo $ReservationID;

			}else{

				echo 2;

			}

		}

	}

}//End of Class
