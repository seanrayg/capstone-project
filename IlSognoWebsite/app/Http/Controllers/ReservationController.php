<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


class ReservationController extends Controller
{
    //
    
    public function addReservation(Request $req){
        // Prepares data to be saved
        $tempCheckInDate = trim($req->input('s-CheckInDate'));
        $tempCheckOutDate = trim($req->input('s-CheckOutDate'));
        $tempPickUpTime = trim($req->input('s-PickUpTime'));
        $NoOfAdults = trim($req->input('s-NoOfAdults'));
        $NoOfKids = trim($req->input('s-NoOfKids'));
        $BoatsUsed = trim($req->input('s-BoatsUsed'));
        $ChosenRooms = trim($req->input('s-ChosenRooms'));
        $FirstName = trim($req->input('s-FirstName'));
        $MiddleName = trim($req->input('s-MiddleName'));
        $LastName = trim($req->input('s-LastName'));
        $Address = trim($req->input('s-Address'));
        $Email = trim($req->input('s-Email'));
        $Contact = trim($req->input('s-Contact'));
        $Nationality = trim($req->input('s-Nationality'));
        $tempDateOfBirth = trim($req->input('s-DateOfBirth'));

        $tempDateOfBirth2 = explode('/', $tempDateOfBirth);
        $tempCheckInDate2 = explode('/', $tempCheckInDate);
        $tempCheckOutDate2 = explode('/', $tempCheckOutDate);
        
        $Birthday = $tempDateOfBirth2[2] ."/". $tempDateOfBirth2[0] ."/". $tempDateOfBirth2[1];
        $CheckInDate = $tempCheckInDate2[2] ."/". $tempCheckInDate2[0] ."/". $tempCheckInDate2[1];
        $CheckOutDate = $tempCheckOutDate2[2] ."/". $tempCheckOutDate2[0] ."/". $tempCheckOutDate2[1];
        $DateBooked = Carbon::now();
        $Gender;
        $Remarks;
        
        $CustomerID = DB::table('tblCustomer')->pluck('strCustomerID')->first();
        if(!$CustomerID){
           $CustomerID = "CUST1";
        }
        else{
           $CustomerID = $this->SmartCounter('tblCustomer', 'strCustomerID');
        }
        
        if(($req->input('s-Gender')) == "Male"){
            $Gender = "M";
        }
        else{
            $Gender = "F";
        }
        
        $tempTime = explode(' ',$tempPickUpTime);
        $PickUpTime = $tempTime[1];
        
        $tempPickUpTime2 = explode(':', $PickUpTime);
        
        $tempPickUpTime2[0] = ((int)$tempPickUpTime2[0]) + 1;
        
        $PickUpTime2 = $tempPickUpTime2[0].":".$tempPickUpTime2[1].":".$tempPickUpTime2[2];
        
        $ReservationID = DB::table('tblReservationDetail')->pluck('strReservationID')->first();
        if(!$ReservationID){
            $ReservationID = "RESV1";
        }
        else{
            $ReservationID = $this->SmartCounter('tblReservationDetail', 'strReservationID');
        }


        if(($req->input('s-Remarks')) == null){
            $Remarks = "N/A";
        }
        else{
            $Remarks = trim($req->input('s-Remarks'));
        }


        
        
        //Saves Customer Data
        $CustomerData = array('strCustomerID'=>$CustomerID,
                          'strCustFirstName'=>$FirstName,
                          'strCustMiddleName'=>$MiddleName,
                          'strCustLastName'=>$LastName,
                          'strCustAddress'=>$Address,
                          'strCustContact'=>$Contact,
                          'strCustEmail'=>$Email,
                          'strCustNationality'=>$Nationality,
                          'strCustGender'=>$Gender,
                          'dtmCustBirthday'=>$Birthday);


        DB::table('tblCustomer')->insert($CustomerData);
        
        
        //Saves Reservation Data
        $ReservationData = array('strReservationID'=>$ReservationID,
                              'intWalkIn'=>'0',
                              'strResDCustomerID'=>$CustomerID,
                              'dtmResDArrival'=>$CheckInDate." 00:00:00",
                              'dtmResDDeparture'=>$CheckOutDate." 00:00:00",
                              'intResDNoOfAdults'=>$NoOfAdults,
                              'intResDNoOfKids'=>$NoOfKids,
                              'strResDRemarks'=>$Remarks,
                              'intResDStatus'=>'1',
                              'dteResDBooking'=>$DateBooked->toDateString());
        
        DB::table('tblReservationDetail')->insert($ReservationData);
        
        
        //Prepares Room Data
        $IndividualRooms = explode(',',$ChosenRooms);
        $IndividualRoomsLength = sizeof($IndividualRooms);
        $IndividualRoomType = [];
        
        for($x = 0; $x < $IndividualRoomsLength; $x++){
            $IndividualRoomDetails = explode('-', $IndividualRooms[$x]);
            $IndividualRoomType[$x] = DB::table('tblRoomType')->where([['strRoomType',"=",$IndividualRoomDetails[0]], ['intRoomTDeleted',"=","1"]])->pluck('strRoomTypeID')->first();
        }
        
        $AvailableRooms = "";
        $IndividualRoomTypeLength = sizeof($IndividualRoomType);
         
        for($x = 0; $x < $IndividualRoomTypeLength; $x++){

            $Rooms = DB::select("SELECT a.strRoomID FROM tblRoom a, tblRoomType b, tblRoomRate c WHERE strRoomID NOT IN(SELECT strResRRoomID FROM tblReservationRoom WHERE strResRReservationID IN(SELECT strReservationID FROM tblReservationDetail WHERE (intResDStatus = 1 OR intResDStatus = 2) AND ((dtmResDDeparture BETWEEN '".$CheckInDate."' AND '".$CheckOutDate."') OR (dtmResDArrival BETWEEN '".$CheckInDate."' AND '".$CheckOutDate."') AND NOT intResDStatus = 3))) AND a.strRoomTypeID = b.strRoomTypeID AND a.strRoomTypeID = c.strRoomTypeID AND a.strRoomStatus = 'Available' AND c.dtmRoomRateAsOf = (SELECT MAX(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID) AND a.strRoomTypeID = '".$IndividualRoomType[$x]."'");
            
            
            foreach($Rooms as $Room){
                $AvailableRooms .= $Room->strRoomID . ",";
            }
            
            $AvailableRooms .= "@";
        }
        
        $arrAvailableRooms = explode('@', $AvailableRooms);
        array_pop($arrAvailableRooms);

  
       
        //Saves Reserved Rooms
        for($x = 0; $x < $IndividualRoomTypeLength; $x++){
           $IndividualRoomsInfo = explode('-', $IndividualRooms[$x]);

           for($y = 0; $y < $IndividualRoomsInfo[3]; $y++){
               $AvailableRoomsArray = explode(',', $arrAvailableRooms[$x]);
               array_pop($AvailableRoomsArray);
               $AvailableRoomsArrayLength = sizeof($AvailableRoomsArray);

                   for($z = 0; $z <= $AvailableRoomsArrayLength; $z++){
                        if($z != $IndividualRoomsInfo[3]){
                            $InsertRoomsData = array('strResRReservationID'=>$ReservationID,
                                                     'strResRRoomID'=>$AvailableRoomsArray[$z]);
                            DB::table('tblReservationRoom')->insert($InsertRoomsData);
                        }
                        else{
                            break;
                        }
                    }
                break;

           }
        }
        
        //Save Reserved Boats
        if($BoatsUsed != null){
            $IndividualBoats = explode(",",$BoatsUsed);
            array_pop($IndividualBoats);
            $IndividualBoatsLength = sizeof($IndividualBoats);
            
            for($x = 0; $x < $IndividualBoatsLength; $x++){
                $temp = "";
                $BoatID = DB::table('tblBoat as a')
                                 ->join ('tblBoatRate as b', 'a.strBoatID', '=' , 'b.strBoatID')
                                    ->select('a.strBoatID')
                                    ->whereNotIn('a.strBoatID', [DB::raw("(SELECT strBoatSBoatID FROM tblBoatSchedule WHERE (date(dtmBoatSPickUp) = '".$CheckInDate."') AND '".$PickUpTime."' BETWEEN time(dtmBoatSPickUp) AND time(DATE_ADD(dtmBoatSPickUp, INTERVAL 1 HOUR)))")])
                                    ->where([['a.strBoatStatus', "=", 'Available'], ['b.dtmBoatRateAsOf',"=", DB::raw("(SELECT max(dtmBoatRateAsOf) FROM tblBoatRate WHERE strBoatID = a.strBoatID)")], ['a.strBoatName', '=', $IndividualBoats[$x]]])
                                    ->orderBy('a.intBoatCapacity')
                                    ->get();
                
                foreach($BoatID as $Boat){
                    $temp = $Boat->strBoatID;
                }
                
                $InsertBoatData = array('strResBReservationID'=>$ReservationID,
                                        'strResBBoatID'=>$temp);
                
                DB::table('tblReservationBoat')->insert($InsertBoatData);
                
                $BoatSchedID = DB::table('tblBoatSchedule')->pluck('strBoatScheduleID')->first();
                if(!$BoatSchedID){
                    $BoatSchedID = "BSCHD1";
                }
                else{
                    $BoatSchedID = $this->SmartCounter('tblBoatSchedule', 'strBoatScheduleID');
                }
                
                $InsertBoatSchedData = array('strBoatScheduleID'=>$BoatSchedID,
                                             'strBoatSBoatID'=>$temp,
                                             'strBoatSPurpose'=>'Reservation',
                                             'dtmBoatSPickUp'=>$CheckInDate." ".$PickUpTime,
                                             'dtmBoatSDropOff'=>$CheckOutDate." ".$PickUpTime2,
                                             'intBoatSStatus'=>'1');
        
                DB::table('tblBoatSchedule')->insert($InsertBoatSchedData);  
       
            }           
                
        }
        dd(Input::all());
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
