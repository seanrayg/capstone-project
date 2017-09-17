<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function RentBoat(Request $request){
    	$strBoatID = $request->input('BoatID');
    	$strCustomerID = $request->input('CustomerID');
    	$intPassengers = $request->input('NumberOfPassengers');
    	$strBoatPurpose = 'Rental';
    	$strPickUpTime = $request->input('time1');
    	$strDropOffTime = $request->input('time2');
        $dblBoatRate = $request->input('BoatRate');

    	$tempPickUpTime = explode(" ", $strPickUpTime);

    	if($tempPickUpTime[1] == 'am'){
    		$tempTime = explode(":", $tempPickUpTime[0]);

            if($tempTime[0] == 12){
                $PickUpTime = '00:' . $tempTime[1] . ':00';
            }else{
                $PickUpTime = $tempPickUpTime[0] . ':00';
            }
    	}else if($tempPickUpTime[1] == 'pm'){
    		$tempTime = explode(":", $tempPickUpTime[0]);

    		if($tempTime[0] == 12){
                $PickUpTime = $tempPickUpTime[0] . ':00';
            }else{
                $intNewHour = 12 + $tempTime[0];
                $PickUpTime = $intNewHour . ':' . $tempTime[1] . ':00';
            }
    	}

        $tempDropOffTime = explode(" ", $strDropOffTime);

        if($tempDropOffTime[1] == 'am'){
            $tempTime = explode(":", $tempDropOffTime[0]);

            if($tempTime[0] == 12){
                $DropOffTime = '00:' . $tempTime[1] . ':00';
            }else{
                $DropOffTime = $tempDropOffTime[0] . ':00';
            }
        }else if($tempDropOffTime[1] == 'pm'){
            $tempTime = explode(":", $tempDropOffTime[0]);

            if($tempTime[0] == 12){
                $DropOffTime = $tempDropOffTime[0] . ':00';
            }else{
                $intNewHour = 12 + $tempTime[0];
                $DropOffTime = $intNewHour . ':' . $tempTime[1] . ':00';
            }
        }

    	$dtmNow = Carbon::now('Asia/Manila');
        $dtNow = $dtmNow->toDateString();

        $dtmBoatSPickUp = $dtNow . ' ' . $PickUpTime;
        $dtmBoatSDropOff = $dtNow . ' ' . $DropOffTime;

        $strReservationID = DB::table('tblReservationDetail')
            ->where('strResDCustomerID', '=', $strCustomerID)
            ->select('strReservationID')
            ->first();

        $strReservationID = $strReservationID->strReservationID;

    	$strBoatScheduleID = $this->SmartCounter('tblBoatSchedule', 'strBoatScheduleID');

    	$BoatSchedule = array(
    		'strBoatScheduleID'=>$strBoatScheduleID,
    		'strBoatSBoatID'=>$strBoatID,
    		'strBoatSPurpose'=>$strBoatPurpose,
    		'dtmBoatSPickUp'=>$dtmBoatSPickUp,
            'dtmBoatSDropOff'=>$dtmBoatSDropOff,
            'intBoatSStatus'=>1,
            'strBoatSReservationID'=>$strReservationID
    	);

        DB::table('tblBoatSchedule')->insert($BoatSchedule);

        $strPaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');

        $BoatScheduleBill = array(
            'strPaymentID'=>$strPaymentID,
            'strPayReservationID'=>$strReservationID,
            'dblPayAmount'=>$dblBoatRate,
            'strPayTypeID'=>8,
            'dtePayDate'=>Carbon::now('Asia/Manila')->toDateString(),
            'strPaymentRemarks'=>null,
            'tmsCreated'=>Carbon::now('Asia/Manila')
        );

        $BoatSchedulePayment = array(
            'strPaymentID'=>$strPaymentID,
            'strPayReservationID'=>$strReservationID,
            'dblPayAmount'=>$dblBoatRate,
            'strPayTypeID'=>9,
            'dtePayDate'=>Carbon::now('Asia/Manila')->toDateString(),
            'strPaymentRemarks'=>null,
            'tmsCreated'=>Carbon::now('Asia/Manila')
        );

        if($request->input('action') == 'Continue'){
            DB::table('tblPayment')->insert($BoatSchedulePayment);
        }else{
            DB::table('tblPayment')->insert($BoatScheduleBill);
        }

    	return redirect('BoatSchedule');
    }

    public function RentDone(Request $request){
        $strBoatScheduleID = $request->input('BoatScheduleID');

        DB::table('tblBoatSchedule')
        ->where('strBoatScheduleID', $strBoatScheduleID)
        ->update(['intBoatSStatus' => 0]);

        return redirect('BoatSchedule');
    }

    public function SmartCounter($strTableName, $strColumnName){
        $endLoop = false;
        $latestID = DB::table($strTableName)->pluck($strColumnName)->first();
        
        $SmartCounter = $this->getID($latestID);
        
        do{
            $DuplicateError = DB::table($strTableName)->where($strColumnName, $SmartCounter)->pluck($strColumnName)->first();
            if($DuplicateError == null){
                $endLoop = true;
            }
            else{
                $SmartCounter = $this->getID($SmartCounter);
            }       
        }while($endLoop == false);
        
        return $SmartCounter;
    }
    
    public function getID($latestID){
        $arrTempID = str_split($latestID);

        $intArrSize = sizeof($arrTempID) - 1;
        $arrNumbers = Array();
        for($i = $intArrSize; $i > 0; $i--){
            if(is_numeric($arrTempID[$i])){
                array_push($arrNumbers, $arrTempID[$i]);
            }else{
                break;
            }
        }

        $arrRevNumbers = array_reverse($arrNumbers);
        $intCounter = implode($arrRevNumbers);
        $intCounterOLen = strlen($intCounter);
        $intCounter += 1;
        $intCounterNLen = strlen($intCounter);
        if($intCounterOLen > $intCounterNLen){
            $intZeroes = $intCounterOLen - $intCounterNLen;
            for($i = 0; $i < $intZeroes; $i++){
                $intCounter = "0" . $intCounter;
            }
        }
        
        array_splice($arrTempID, (sizeof($arrTempID) - sizeof($arrNumbers)), sizeof($arrNumbers));

        $strSmartCounter = implode($arrTempID) . $intCounter;
        
        return $strSmartCounter;
    }
}
