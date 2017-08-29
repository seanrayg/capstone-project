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
    	$strBoatPurpose = $request->input('BoatPurpose');
    	$strPickUpTime = $request->input('time1');
    	$strDropOffTime = $request->input('time2');

    	$tempPickUpTime = explode(" ", $strPickUpTime);

    	if($tempPickUpTime[1] == 'am'){
    		$PickUpTime = $tempPickUpTime[0] . ':00';
    	}else if($tempPickUpTime[1] == 'pm'){
    		$tempPickUpTime = explode(":", $tempPickUpTime[0]);

    		$intNewHour = 12 + $tempPickUpTime[0];
    		$PickUpTime = $intNewHour . ':' . $tempPickUpTime[1] . ':00';
    	}

        $tempPickUpTime = explode(" ", $strDropOffTime);

        if($tempPickUpTime[1] == 'am'){
            $DropOffTime = $tempPickUpTime[0] . ':00';
        }else if($tempPickUpTime[1] == 'pm'){
            $tempPickUpTime = explode(":", $tempPickUpTime[0]);

            $intNewHour = 12 + $tempPickUpTime[0];
            $DropOffTime = $intNewHour . ':' . $tempPickUpTime[1] . ':00';
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
