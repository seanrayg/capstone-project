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
    
    /* Reservation Status
    
        1 = Floating Reservation
        2 = Paid Reservation
        3 = Cancelled Reservation
        4 = Nasa resort na
        5 = Tapos na yung stay
    */
    
            
    /* Payment Type Code Reference
        1 = Floating Reservation
        2 = Paid Reservation
        3 = Cancelled Reservation
        4 = Checked in
        5 = Checked out
        6 = Other Bills
    */
    
    /* Payment Status for Amenities
        0 = not paid
        1 = paid
    */
    
    //Book Reservation
    
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
        $InitialBill = trim($req->input('s-InitialBill'));
        $tempDateOfBirth2 = explode('/', $tempDateOfBirth);
        $tempCheckInDate2 = explode('/', $tempCheckInDate);
        $tempCheckOutDate2 = explode('/', $tempCheckOutDate);
        
        $Birthday = $tempDateOfBirth2[2] ."/". $tempDateOfBirth2[0] ."/". $tempDateOfBirth2[1];
        $CheckInDate = $tempCheckInDate2[2] ."/". $tempCheckInDate2[0] ."/". $tempCheckInDate2[1];
        $CheckOutDate = $tempCheckOutDate2[2] ."/". $tempCheckOutDate2[0] ."/". $tempCheckOutDate2[1];
        $DateBooked = Carbon::now();
        $Gender;
        $Remarks;
        $PickOutTime;
        //gets customer id
    

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
        
        $CustomerID = $this->getCustomerID();
                
        $ReservationID = $this->getReservationID();
        
        $PaymentID = $this->getPaymentID();
        
        $ReservationCode = $this->getReservationCode();
        
        if(($req->input('s-Remarks')) == null){
            $Remarks = "N/A";
        }
        else{
            $Remarks = trim($req->input('s-Remarks'));
        }
        
        if(($req->input('s-Remarks')) == null){
            $Remarks = "N/A";
        }
        else{
            $Remarks = trim($req->input('s-Remarks'));
        }
        
        $this->saveCustomerData($CustomerID, $FirstName, $MiddleName, $LastName, $Address, $Contact, $Email, $Nationality, $Gender, $Birthday);
        
        if($CheckInDate == $CheckOutDate){
            $PickOutTime = "23:59:59";
        }
        else{
            $PickOutTime = $PickUpTime;
        }
        
        $this->saveReservationData($ReservationID, $CustomerID, $CheckInDate, $PickUpTime, $CheckOutDate, $PickOutTime, $NoOfAdults, $NoOfKids, $Remarks, $DateBooked, $ReservationCode);
        
        $CheckInDate2 = $CheckInDate ." ". $PickUpTime;
        $CheckOutDate2 = $CheckOutDate ." ". $PickOutTime;

        $PaymentStatus = 0;
        $this->saveReservedRooms($ChosenRooms, $CheckInDate2, $CheckOutDate2, $ReservationID, $PaymentStatus);
        
        //Save Reserved Boats
        if($BoatsUsed != null){
               $this->saveReservedBoats($ReservationID, $CheckInDate, $CheckOutDate, $PickUpTime, $PickUpTime2, $BoatsUsed);          
        }
        
      
        $this->saveReservationTransaction($PaymentID, $ReservationID, $InitialBill, $DateBooked);
        
        //Check if there is an entrance fee
        $EntranceFeeID = DB::table('tblFee as a')
                ->join ('tblFeeAmount as b', 'a.strFeeID', '=' , 'b.strFeeID')
                ->select('a.strFeeID')
                ->where([['b.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")],['a.strFeeStatus', '=', 'Active'],['a.strFeeName', '=', 'Entrance Fee']])
                ->pluck('strFeeID')->first();
        //saves entrance fee
        if(sizeof($EntranceFeeID) != 0){
            $this->addFees($EntranceFeeID, $NoOfAdults, $PaymentStatus, $ReservationID);
        }
            
        
        
         \Session::flash('flash_message','Reservation successfully booked! The reservation code of '. $FirstName . ' ' . $LastName . ' is ' . $ReservationCode.'.');
         return redirect('/Reservations');
    }
    
    //Book Reservation with package
    
    public function addReservationPackage(Request $req){
        $tempCheckInDate = trim($req->input('s-CheckInDate'));
        $tempCheckOutDate = trim($req->input('s-CheckOutDate'));
        $tempPickUpTime = trim($req->input('s-PickUpTime'));
        $BoatsUsed = trim($req->input('s-BoatsUsed'));
        $FirstName = trim($req->input('s-FirstName'));
        $MiddleName = trim($req->input('s-MiddleName'));
        $LastName = trim($req->input('s-LastName'));
        $Address = trim($req->input('s-Address'));
        $Email = trim($req->input('s-Email'));
        $Contact = trim($req->input('s-Contact'));
        $Nationality = trim($req->input('s-Nationality'));
        $Gender = trim($req->input('s-Gender'));
        $tempDateOfBirth = trim($req->input('s-DateOfBirth'));
        $InitialBill = trim($req->input('s-InitialBill'));
        $PackageID = trim($req->input('s-PackageID'));
        $Remarks = trim($req->input('s-Remarks'));
        $NoOfKids = trim($req->input('s-NoOfKids'));
        $NoOfAdults = trim($req->input('s-NoOfAdults'));

        $Birthday = Carbon::parse($tempDateOfBirth)->format('Y/m/d');
        $CheckInDate = Carbon::parse($tempCheckInDate)->format('Y/m/d');
        $CheckOutDate = Carbon::parse($tempCheckOutDate)->format('Y/m/d');
        $PickUpTime = Carbon::parse($tempPickUpTime)->format('H:i:s');
        $PickUpTime2 = Carbon::parse($tempPickUpTime)->addHours(1)->format('H:i:s');
  
        $PickOutTime = $PickUpTime;
        
        $DateBooked = Carbon::now();
        
        $CustomerID = $this->getCustomerID();
                
        $ReservationID = $this->getReservationID();
        
        $PaymentID = $this->getPaymentID();
        
        $ReservationCode = $this->getReservationCode();
        
        $PackageRoomInfo = DB::table('tblRoomType as a')
                        ->join('tblPackageRoom as b', 'a.strRoomTypeID', '=', 'b.strPackageRRoomTypeID')
                        ->join('tblRoomRate as c', 'a.strRoomTypeID', '=', 'c.strRoomTypeID')
                        ->select('a.strRoomType',
                                 'a.intRoomTCapacity',
                                 'b.intPackageRQuantity',
                                 'c.dblRoomRate')
                        ->where([['b.strPackageRPackageID', '=', $PackageID], ['c.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")]])
                        ->get();
        

        $ChosenRooms = "";
        foreach($PackageRoomInfo as $Info){
            $ChosenRooms .= $Info -> strRoomType . "-" . $Info -> intRoomTCapacity ."-". $Info -> dblRoomRate ."-".$Info->intPackageRQuantity.",";
        }
        
        $ChosenRooms = rtrim($ChosenRooms,",");
  
        if($Gender == "Male"){
            $Gender = "M";
        }
        else{
            $Gender = "F";
        }
        
        
        if($Remarks == null){
            $Remarks = "N/A";
        }
        
        if($CheckInDate == $CheckOutDate){
            $PickOutTime = "23:59:59";
        }
        
        //save customer data
        $this->saveCustomerData($CustomerID, $FirstName, $MiddleName, $LastName, $Address, $Contact, $Email, $Nationality, $Gender, $Birthday);
        
        //save reservation data
        $this->saveReservationData($ReservationID, $CustomerID, $CheckInDate, $PickUpTime, $CheckOutDate, $PickOutTime, $NoOfAdults, $NoOfKids, $Remarks, $DateBooked, $ReservationCode);
        
        //save reserved rooms
        $CheckInDate2 = $CheckInDate ." ". $PickUpTime;
        $CheckOutDate2 = $CheckOutDate ." ". $PickOutTime;

        $PaymentStatus = 1;
        $this->saveReservedRooms($ChosenRooms, $CheckInDate2, $CheckOutDate2, $ReservationID, $PaymentStatus);
        
        //Save Reserved Boats
        if($BoatsUsed != null){
               $this->saveReservedBoats($ReservationID, $CheckInDate, $CheckOutDate, $PickUpTime, $PickUpTime2, $BoatsUsed);          
        }
        
        //save reservation transaction payment
        $this->saveReservationTransaction($PaymentID, $ReservationID, $InitialBill, $DateBooked);
        
        //Check if there is an entrance fee
        $EntranceFeeID = DB::table('tblFee as a')
                ->join ('tblFeeAmount as b', 'a.strFeeID', '=' , 'b.strFeeID')
                ->select('a.strFeeID')
                ->where([['b.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")],['a.strFeeStatus', '=', 'Active'],['a.strFeeName', '=', 'Entrance Fee']])
                ->pluck('strFeeID')->first();
        
        $EntranceIncluded = DB::table('tblPackageFee')
                            ->where([['strPackageFFeeID', '=', $EntranceFeeID],['strPackageFPackageID', '=', $PackageID]])
                            ->get();
        
        //saves entrance fee
        if(sizeof($EntranceFeeID) != 0){
            if(sizeof($EntranceIncluded) != 0){
                $PaymentStatus = 1;
            }   
            $this->addFees($EntranceFeeID, $NoOfAdults, $PaymentStatus, $ReservationID);
        }
        
        $PackageData = array('strAvailPReservationID'=>$ReservationID,
                              'strAvailPackageID'=>$PackageID);
        
        DB::table('tblAvailPackage')->insert($PackageData);
        
        \Session::flash('flash_message','Reservation successfully booked! The reservation code of '. $FirstName . ' ' . $LastName . ' is ' . $ReservationCode.'.');
         return redirect('/Reservations');
    }
    
    public function saveCustomerData($CustomerID, $FirstName, $MiddleName, $LastName, $Address, $Contact, $Email, $Nationality, $Gender, $Birthday){
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
                          'dtmCustBirthday'=>$Birthday,
                          'intCustomerConfirmed' => '0',
                          'intCustStatus' => '1');


        DB::table('tblCustomer')->insert($CustomerData);
    }
    
    public function saveReservationData($ReservationID, $CustomerID, $CheckInDate, $PickUpTime, $CheckOutDate, $PickOutTime, $NoOfAdults, $NoOfKids, $Remarks, $DateBooked, $ReservationCode){
        //Saves Reservation Data
        $ReservationData = array('strReservationID'=>$ReservationID,
                              'intWalkIn'=>'0',
                              'strResDCustomerID'=>$CustomerID,
                              'dtmResDArrival'=>$CheckInDate." ".$PickUpTime,
                              'dtmResDDeparture'=>$CheckOutDate." ".$PickOutTime,
                              'intResDNoOfAdults'=>$NoOfAdults,
                              'intResDNoOfKids'=>$NoOfKids,
                              'strResDRemarks'=>$Remarks,
                              'intResDStatus'=>'1',
                              'dteResDBooking'=>$DateBooked->toDateString(),
                              'strReservationCode'=>$ReservationCode);
        
        DB::table('tblReservationDetail')->insert($ReservationData);
    }
    
    public function saveReservationTransaction($PaymentID, $ReservationID, $InitialBill, $DateBooked){
          //Save Transaction
        $TransactionData = array('strPaymentID'=>$PaymentID,
                              'strPayReservationID'=>$ReservationID,
                              'dblPayAmount'=>$InitialBill,
                              'strPayTypeID'=> 1,
                              'dtePayDate'=>$DateBooked->toDateString());
        
        DB::table('tblPayment')->insert($TransactionData);
    }

    public function getCustomerID(){
        $CustomerID = DB::table('tblCustomer')->pluck('strCustomerID')->first();
        if(!$CustomerID){
           $CustomerID = "CUST1";
        }
        else{
           $CustomerID = $this->SmartCounter('tblCustomer', 'strCustomerID');
        }
        
        return $CustomerID;
    }
    
    public function getReservationID(){
        $ReservationID = DB::table('tblReservationDetail')->pluck('strReservationID')->first();
        if(!$ReservationID){
            $ReservationID = "RESV1";
        }
        else{
            $ReservationID = $this->SmartCounter('tblReservationDetail', 'strReservationID');
        }
        
        return $ReservationID;
    }
    
    public function getPaymentID(){
        $PaymentID = DB::table('tblPayment')->pluck('strPaymentID')->first();
        if(!$PaymentID){
            $PaymentID = "PYMT1";
        }
        else{
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
        }

        return $PaymentID;
    }
    
    public function getReservationCode(){
        $endLoop = false;
        //Generate Random Reservation Code
        do{
            $ReservationCode = $this->RandomString();
            $DuplicateError = DB::table("tblReservationDetail")->where("strReservationCode", $ReservationCode)->pluck("strReservationCode")->first();
            if($DuplicateError == null){
                $endLoop = true;
            }
            else{
                $ReservationCode = $this->RandomString();
            }    
        }while($endLoop == false);
        
        return $ReservationCode;
    }
    
    public function RandomString() {
        $length = 6;
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max-1)];
        }

        return $token;
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
    
    
    //Edit Reservation
    
    
    //Edit Reservation Info
    
    public function updateReservationInfo(Request $req){
        $ReservationID = trim($req->input('info-ReservationID'));
        $NoOfAdults = trim($req->input('NoOfAdults'));
        $NoOfKids = trim($req->input('NoOfKids'));
        $Remarks = trim($req->input('Remarks'));
        $BoatsUsed = trim($req->input('info-BoatsUsed'));
        $PickUpTime = trim($req->input('info-PickUpTime'));
        $CheckInDate = trim($req->input('info-CheckInDate'));
        $CheckOutDate = trim($req->input('info-CheckOutDate'));
        $updateData = array("intResDNoOfAdults" => $NoOfAdults, 
                     'intResDNoOfKids' => $NoOfKids,
                     'strResDRemarks' => $Remarks);   
        
        DB::table('tblReservationDetail')
            ->where('strReservationID', $ReservationID)
            ->update($updateData);

        if($BoatsUsed != null){
            $tempPickUpTime2 = explode(':', $PickUpTime);
            $tempPickUpTime2[0] = ((int)$tempPickUpTime2[0]) + 1;
            $PickUpTime2 = $tempPickUpTime2[0].":".$tempPickUpTime2[1].":".$tempPickUpTime2[2];
                                                                                            
            DB::table('tblreservationboat')->where('strResBReservationID', '=', $ReservationID)->delete();
            DB::table('tblboatschedule')->where('strBoatSReservationID', '=', $ReservationID)->delete();
            $this->saveReservedBoats($ReservationID, $CheckInDate, $CheckOutDate, $PickUpTime, $PickUpTime2, $BoatsUsed);
        }
        \Session::flash('flash_message','Reservation successfully updated!');
         return redirect('/Reservations');
    }
    
    //Edit Reservation Room
    
    public function updateReservationRoom(Request $req){
        $tempCheckInDate = trim($req->input('r-CheckInDate'));
        $tempCheckOutDate = trim($req->input('r-CheckOutDate'));
        $ChosenRooms = trim($req->input('ChosenRooms'));
        $ReservationID = trim($req->input('r-ReservationID'));
        $NoOfAdults = trim($req->input('r-NoOfAdults'));
        $NoOfKids = trim($req->input('r-NoOfKids'));
        $BoatsUsed = trim($req->input('r-BoatsUsed'));
        $PickUpTime = trim($req->input('r-PickUpTime'));
        $PickOutTime;
        
        if($tempCheckInDate == $tempCheckOutDate){
            $PickOutTime = $PickUpTime;
        }
        else{
            $PickOutTime = "23:59:59";
        }
        
        $CheckInDate = $tempCheckInDate ." ". $PickUpTime;
        $CheckOutDate = $tempCheckInDate ." ". $PickOutTime;
        
        $PaymentStatus = 0;
        DB::table('tblreservationroom')->where('strResRReservationID', '=', $ReservationID)->delete();
        $this->saveReservedRooms($ChosenRooms, $CheckInDate, $CheckOutDate, $ReservationID, $PaymentStatus);
        
        if($NoOfKids != null && $NoOfKids != null){
            $updateData = array("intResDNoOfAdults" => $NoOfAdults, 
                     'intResDNoOfKids' => $NoOfKids);   
        
            DB::table('tblReservationDetail')
                ->where('strReservationID', $ReservationID)
                ->update($updateData);
        }
        
        if($BoatsUsed != null){
            $tempPickUpTime2 = explode(':', $PickUpTime);
            $tempPickUpTime2[0] = ((int)$tempPickUpTime2[0]) + 1;
            $PickUpTime2 = $tempPickUpTime2[0].":".$tempPickUpTime2[1].":".$tempPickUpTime2[2];
                                                                                            
            DB::table('tblreservationboat')->where('strResBReservationID', '=', $ReservationID)->delete();
            DB::table('tblboatschedule')->where('strBoatSReservationID', '=', $ReservationID)->delete();
            $this->saveReservedBoats($ReservationID, $tempCheckInDate, $tempCheckOutDate, $PickUpTime, $PickUpTime2, $BoatsUsed);
        }
        
        $CheckInDate = str_replace("/","-",$tempCheckInDate);
        $CheckOutDate = str_replace("/","-",$tempCheckOutDate);
        
        $tempArrivalDate = $CheckInDate ." ". $PickUpTime;
        $tempDepartureDate = $CheckOutDate ." ". $PickUpTime;
   
        $DateChecker = false;
        
        $OldReservationDates = DB::table('tblReservationDetail')
                                ->select('dtmResDArrival',
                                         'dtmResDDeparture')
                                ->where('strReservationID', $ReservationID)
                                ->get();

        foreach($OldReservationDates as $OldDate){
            if($OldDate->dtmResDArrival == $tempArrivalDate && $OldDate->dtmResDDeparture == $tempDepartureDate){
                $DateChecker = true;
            }
            else{
                $DateChecker = false;
            }
        }
        
        $arrCheckInDate = explode(' ', $tempArrivalDate);
        $arrCheckOutDate = explode(' ', $tempDepartureDate);
 
        $tempCheckInDate2 = explode('-', $arrCheckInDate[0]);
        $tempCheckOutDate2 = explode('-', $arrCheckOutDate[0]);

        $CheckInDate = $tempCheckInDate2[2] ."/". $tempCheckInDate2[0] ."/". $tempCheckInDate2[1] ." ". $arrCheckInDate[1];
        $CheckOutDate = $tempCheckOutDate2[2] ."/". $tempCheckOutDate2[0] ."/". $tempCheckOutDate2[1] ." ". $arrCheckOutDate[1];
        
        if(!$DateChecker){
            $updateDateData = array("dtmResDArrival" => $CheckInDate, 
                     'dtmResDDeparture' => $CheckOutDate);   
        
            DB::table('tblReservationDetail')
                ->where('strReservationID', $ReservationID)
                ->update($updateDateData);
            
            $ChosenBoats = DB::table('tblReservationBoat')->where('strResBReservationID', "=", $ReservationID)->pluck('strResBBoatID');
            if(count($ChosenBoats) != 0){
                DB::table('tblreservationboat')->where('strResBReservationID', '=', $ReservationID)->delete();
                DB::table('tblboatschedule')->where('strBoatSReservationID', '=', $ReservationID)->delete();
                $this->saveReservedBoats($ReservationID, $tempCheckInDate, $tempCheckOutDate, $PickUpTime, $PickUpTime2, $BoatsUsed);
            }
            
        }
        
        \Session::flash('flash_message','Reservation successfully updated!');
        return redirect('/Reservations');
    }
    
    //Edit Reservation Date
    
    public function updateReservationDate(Request $req){
        $tempCheckInDate = trim($req->input('CheckInDate'));
        $tempCheckOutDate = trim($req->input('CheckOutDate'));
        $PickUpHour = trim($req->input('SelectHour'));
        $PickUpMinute = trim($req->input('SelectMinute'));
        $PickUpMerridean = trim($req->input('SelectMerridean'));
        $ReservationID = trim($req->input('d-ReservationID'));
   
        $tempCheckInDate2 = explode('/', $tempCheckInDate);
        $tempCheckOutDate2 = explode('/', $tempCheckOutDate);

        $CheckInDate = $tempCheckInDate2[2] ."/". $tempCheckInDate2[0] ."/". $tempCheckInDate2[1];
        $CheckOutDate = $tempCheckOutDate2[2] ."/". $tempCheckOutDate2[0] ."/". $tempCheckOutDate2[1];
        
        $PickUpTime = "";
        
        if($PickUpMerridean == "PM"){
            $PickUpTime = ((int)$PickUpHour + 12) .":". $PickUpMinute .":00";
        }
        else{
            $PickUpTime = $PickUpHour .":". $PickUpMinute .":00";
        }
        
        $updateData = array("dtmResDArrival" => $CheckInDate." ".$PickUpTime, 
                     'dtmResDDeparture' => $CheckOutDate." ".$PickUpTime);   
        
        DB::table('tblReservationDetail')
            ->where('strReservationID', $ReservationID)
            ->update($updateData);
        
        $ChosenBoats = DB::table('tblReservationBoat')->where('strResBReservationID', "=", $ReservationID)->pluck('strResBBoatID');
        if(count($ChosenBoats) != 0){
            $boatSchedData = array("dtmBoatSPickUp" => $CheckInDate." ".$PickUpTime, 
                                   'dtmBoatSDropoff' => $CheckOutDate." ".$PickUpTime); 
            
            DB::table('tblBoatSchedule')
            ->where([['strBoatSReservationID', $ReservationID],['strBoatSPurpose', 'Reservation']])
            ->update($boatSchedData);
        }
        
        \Session::flash('flash_message','Reservation successfully updated!');
         return redirect('/Reservations');
        
    }
    
    public function saveReservedRooms($ChosenRooms, $CheckInDate, $CheckOutDate, $ReservationID, $PaymentStatus){
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
            
            
            $ExistingReservations = DB::table('tblReservationDetail')
                                ->where(function($query){
                                    $query->where('intResDStatus', '=', '1')
                                          ->orWhere('intResDStatus', '=', '2')
                                          ->orWhere('intResDStatus', '=', '4');
                                })
                                ->where(function($query) use($CheckInDate, $CheckOutDate){
                                    $query->where('dtmResDArrival','>=',$CheckInDate)
                                          ->where('dtmResDArrival','<=',$CheckOutDate);
                                })
                                ->orWhere(function($query) use($CheckInDate, $CheckOutDate){
                                    $query->where('dtmResDDeparture','>=',$CheckInDate)
                                          ->where('dtmResDDeparture','<=',$CheckOutDate);
                                })
                                ->where(function($query) use($CheckInDate, $CheckOutDate){
                                    $query->where('dtmResDArrival','<=',$CheckInDate)
                                          ->where('dtmResDDeparture','>=',$CheckInDate);
                                })
                                ->orWhere(function($query) use($CheckInDate, $CheckOutDate){
                                    $query->where('dtmResDArrival','<=',$CheckOutDate)
                                          ->where('dtmResDDeparture','>=',$CheckOutDate);
                                })
                                ->pluck('strReservationID')
                                ->toArray();
        
            $ExistingRooms = DB::table('tblReservationRoom')
                                    ->whereIn('strResRReservationID', $ExistingReservations)
                                    ->pluck('strResRRoomID')
                                    ->toArray();

            $tempArrivalDate = explode(" ", $CheckInDate);
            $tempDepartureDate = explode(" ", $CheckOutDate);

            $Rooms = DB::table('tblRoom as a')
                        ->join ('tblRoomType as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
                        ->join ('tblRoomRate as c', 'a.strRoomTypeID', '=' , 'c.strRoomTypeID')
                        ->select('a.strRoomID')
                         ->whereNotIn('strRoomID', $ExistingRooms)
                         ->where([['a.strRoomStatus','=','Available'],['c.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],['a.strRoomTypeID', '=', $IndividualRoomType[$x]]])
                         ->groupBy('a.strRoomID')
                         ->get();
            
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
                                                     'strResRRoomID'=>$AvailableRoomsArray[$z],
                                                     'intResRPayment'=>$PaymentStatus);
                            DB::table('tblReservationRoom')->insert($InsertRoomsData);
                        }
                        else{
                            break;
                        }
                    }
                break;

           }
        }
    }
    
    
    //Cancel Reservation
    
    public function cancelReservation(Request $req){
        $ReservationID = trim($req->input('CancelReservationID'));
        
        $updateData = array("intResDStatus" => "3");   
        
        DB::table('tblReservationDetail')
            ->where('strReservationID', $ReservationID)
            ->update($updateData);
        
        $ChosenBoats = DB::table('tblReservationBoat')->where('strResBReservationID', "=", $ReservationID)->pluck('strResBBoatID');
        if(count($ChosenBoats) != 0){
            $updateBoatData = array("intBoatSStatus" => "0");
            DB::table('tblBoatSchedule')
                ->where('strBoatSReservationID', $ReservationID)
                ->update($updateBoatData);
        }
        
        \Session::flash('flash_message','Reservation successfully cancelled!');
         return redirect('/Reservations');
    }
    
    
    //Check in Reservation
    
    public function checkInReservation(Request $req){
        $ReservationID = trim($req->input('CheckInReservationID'));
        
        $updateData = array("intResDStatus" => "4");   
        
        DB::table('tblReservationDetail')
            ->where('strReservationID', $ReservationID)
            ->update($updateData);
        
        \Session::flash('flash_message','Booked successfully!');
        \Session::flash('ReservationID', $ReservationID);
        return redirect('/ChooseRooms/'.$ReservationID);
    }
    
    //Check in Reservation with Payment
    public function checkInReservationPayment(Request $req){
        $ReservationID = trim($req->input('PayReservationID'));
        
        $updateData = array("intResDStatus" => "4");   
        
        DB::table('tblReservationDetail')
            ->where('strReservationID', $ReservationID)
            ->update($updateData);
        
        DB::table('tblReservationRoom')
            ->where('strResRReservationID', $ReservationID)
            ->update(['intResRPayment' => 1]);
        
        DB::table('tblReservationBoat')
            ->where('strResBReservationID', $ReservationID)
            ->update(['intResBPayment' => 1]);
        
        DB::table('tblReservationFee')
            ->where('strResFReservationID', $ReservationID)
            ->update(['intResFPayment' => 1]);
        
        \Session::flash('flash_message','Booked successfully!');
        \Session::flash('ReservationID', $ReservationID);
        return redirect('/ChooseRooms/'.$ReservationID);
        
    }
    
    
    //Save Downpayment
    
    public function saveDownPayment(Request $req){
        $ReservationID = trim($req->input('d-ReservationID'));
        $DownpaymentAmount = trim($req->input('d-DownpaymentAmount'));
        
        $DateToday = Carbon::now()->toDateString();
        
        $PaymentID = DB::table('tblPayment')->pluck('strPaymentID')->first();
        if(!$PaymentID){
            $PaymentID = "PYMT1";
        }
        else{
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
        }
        
        $TransactionData = array('strPaymentID'=>$PaymentID,
                              'strPayReservationID'=>$ReservationID,
                              'dblPayAmount'=>$DownpaymentAmount,
                              'strPayTypeID'=> 2,
                              'dtePayDate'=>$DateToday);
        
        DB::table('tblPayment')->insert($TransactionData);
        
        $updateData = array("intResDStatus" => "2");   
        
        DB::table('tblReservationDetail')
            ->where('strReservationID', $ReservationID)
            ->update($updateData);
        
        \Session::flash('flash_message','Process successfully done!');
         return redirect('/Reservations');
    }
    
    //MISC
    public function saveReservedBoats($ReservationID, $CheckInDate, $CheckOutDate, $PickUpTime, $PickUpTime2, $BoatsUsed){
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
                                    'strResBBoatID'=>$temp,
                                    'intResBPayment'=> '0');

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
                                         'dtmBoatSDropOff'=>$CheckInDate." ".$PickUpTime2,
                                         'intBoatSStatus'=>'1',
                                         'strBoatSReservationID' => $ReservationID);

            DB::table('tblBoatSchedule')->insert($InsertBoatSchedData);  

        }   
    }
    
    
    
    
    /*----------------- WALK IN -------------------*/
    
    public function addWalkIn(Request $req){
         
        // Prepares data to be saved
        $tempCheckInDate = trim($req->input('s-CheckInDate'));
        $tempCheckOutDate = trim($req->input('s-CheckOutDate'));
        $NoOfAdults = trim($req->input('s-NoOfAdults'));
        $NoOfKids = trim($req->input('s-NoOfKids'));
        $ChosenRooms = trim($req->input('s-ChosenRooms'));
        $FirstName = trim($req->input('s-FirstName'));
        $MiddleName = trim($req->input('s-MiddleName'));
        $LastName = trim($req->input('s-LastName'));
        $Address = trim($req->input('s-Address'));
        $Email = trim($req->input('s-Email'));
        $Contact = trim($req->input('s-Contact'));
        $Nationality = trim($req->input('s-Nationality'));
        $tempDateOfBirth = trim($req->input('s-DateOfBirth'));
        $GrandTotal = trim($req->input('s-GrandTotal'));
        $AmountTendered = trim($req->input('s-AmountTendered'));
        $OtherFees = trim($req->input('s-OtherFees'));
        $AddFees = json_decode($req->input('s-AddFees'));
       
        $PaymentStatus = 0;
        if($AmountTendered != null){
            $PaymentStatus = 1;
        }

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
        
        $dt = Carbon::now('HongKong');
        $TimeToday = $dt->toTimeString();          
        $PickOutTime = "";
        $PickUpTime = "";
        $arrTimeToday = explode(':', $TimeToday);
        /*
        if(((int)$arrTimeToday[1] >= 00) && ((int)$arrTimeToday[1]<=15)){
            $PickUpTime = $arrTimeToday[0] .":00:00"; 
        }
        else if(((int)$arrTimeToday[1] >= 15) && ((int)$arrTimeToday[1]<=30)){
            $PickUpTime = $arrTimeToday[0] .":15:00";
        }
        else if(((int)$arrTimeToday[1] >= 30) && ((int)$arrTimeToday[1]<=45)){
            $PickUpTime = $arrTimeToday[0] .":30:00";
        }
        else{
            $PickUpTime = $arrTimeToday[0] .":45:00";
        }*/
        $PickUpTime = $TimeToday;
        
        
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
        
        $endLoop = false;
        
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
                          'dtmCustBirthday'=>$Birthday,
                          'intCustomerConfirmed' => '1',
                          'intCustStatus' => '1');


        DB::table('tblCustomer')->insert($CustomerData);
        
        if($CheckInDate == $CheckOutDate){
            $PickOutTime = "23:59:59";
        }
        else{
            $PickOutTime = $PickUpTime;
        }
        
        //Saves Reservation Data
        $ReservationData = array('strReservationID'=>$ReservationID,
                              'intWalkIn'=>'1',
                              'strResDCustomerID'=>$CustomerID,
                              'dtmResDArrival'=>$CheckInDate." ".$PickUpTime,
                              'dtmResDDeparture'=>$CheckOutDate." ".$PickOutTime,
                              'intResDNoOfAdults'=>$NoOfAdults,
                              'intResDNoOfKids'=>$NoOfKids,
                              'strResDRemarks'=>$Remarks,
                              'intResDStatus'=>'4',
                              'dteResDBooking'=>$DateBooked->toDateString(),
                              'strReservationCode'=>null);
        
        DB::table('tblReservationDetail')->insert($ReservationData);   
        
        
        $CheckInDate2 = $CheckInDate ." ". $PickUpTime;
        $CheckOutDate2 = $CheckOutDate ." ". $PickOutTime;
        
      
        //saves reserved rooms
        $this->saveReservedRooms($ChosenRooms, $CheckInDate2, $CheckOutDate2, $ReservationID, $PaymentStatus);

        
        //saves payment
        $PaymentID = DB::table('tblPayment')->pluck('strPaymentID')->first();
        if(!$PaymentID){
            $PaymentID = "PYMT1";
        }
        else{
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
        }
        
        $TransactionData = array('strPaymentID'=>$PaymentID,
                              'strPayReservationID'=>$ReservationID,
                              'dblPayAmount'=>$GrandTotal,
                              'strPayTypeID'=> 1,
                              'dtePayDate'=>$DateBooked->toDateString());
        
        DB::table('tblPayment')->insert($TransactionData);
        
        if($PaymentStatus == 1){
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
            $TransactionData2 = array('strPaymentID'=>$PaymentID,
                                  'strPayReservationID'=>$ReservationID,
                                  'dblPayAmount'=>$GrandTotal,
                                  'strPayTypeID'=> 3,
                                  'dtePayDate'=>$DateBooked->toDateString());
        
            DB::table('tblPayment')->insert($TransactionData2);
        }
        
        //save Fees
        if(sizeof($AddFees) != 0){
            foreach($AddFees as $Fee){
                $FeeName = $Fee->FeeName;
                $FeeAmount = $Fee->FeeAmount;
                $this->saveFees($FeeName, $FeeAmount);
            }
        }
        
        if($OtherFees != null){
            $arrOtherFees = explode(',', $OtherFees);

            for($x = 0; $x < sizeof($arrOtherFees); $x++){
                $arrFee = explode('-', $arrOtherFees[$x]);
                $FeeID = DB::table('tblFee')->where([['strFeeStatus', 'Active'],['strFeeName', $arrFee[0]]])->orderBy('strFeeID')->pluck('strFeeID');
                if(sizeof($FeeID) != 0){
                    $this->addFees($FeeID[0], $arrFee[2], $PaymentStatus, $ReservationID);
                }
            }
        }
        
        //Check if there is an entrance fee
        $EntranceFeeID = DB::table('tblFee as a')
                ->join ('tblFeeAmount as b', 'a.strFeeID', '=' , 'b.strFeeID')
                ->select('a.strFeeID')
                ->where([['b.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")],['a.strFeeStatus', '=', 'Active'],['a.strFeeName', '=', 'Entrance Fee']])
                ->pluck('strFeeID')->first();
        //saves entrance fee
        if(sizeof($EntranceFeeID) != 0){
            $this->addFees($EntranceFeeID, $NoOfAdults, $PaymentStatus, $ReservationID);
        }
        
        \Session::flash('flash_message','Booked successfully!');
        \Session::flash('ReservationID', $ReservationID);
        return redirect('/ChooseRooms/'.$ReservationID);
    }
    
    public function addWalkInPackagePayNow(Request $req){

        $tempCheckInDate = trim($req->input('pn-CheckInDate'));
        $tempCheckOutDate = trim($req->input('pn-CheckOutDate'));
        $NoOfAdults = trim($req->input('pn-NoOfAdults'));
        $NoOfKids = trim($req->input('pn-NoOfKids'));
        $FirstName = trim($req->input('pn-FirstName'));
        $MiddleName = trim($req->input('pn-MiddleName'));
        $LastName = trim($req->input('pn-LastName'));
        $Address = trim($req->input('pn-Address'));
        $Email = trim($req->input('pn-Email'));
        $Contact = trim($req->input('pn-Contact'));
        $Nationality = trim($req->input('pn-Nationality'));
        $tempDateOfBirth = trim($req->input('pn-DateOfBirth'));
        $Gender = trim($req->input('pn-Gender'));
        $Remarks = trim($req->input('pn-Remarks'));
        $TotalAmount = trim($req->input('pn-InitialBill'));
        $PackageID = trim($req->input('pn-PackageID'));
        
        $Birthday = Carbon::parse($tempDateOfBirth)->format('Y/m/d');
        $CheckInDate = Carbon::parse($tempCheckInDate)->format('Y/m/d');
        $CheckOutDate = Carbon::parse($tempCheckOutDate)->format('Y/m/d');
        $PickUpTime = Carbon::now()->format('H:i:s');
        $PickUpTime2 = Carbon::now()->addHours(1)->format('H:i:s');
  
        $PickOutTime = $PickUpTime;
        
        $DateBooked = Carbon::now();
        
        $CustomerID = $this->getCustomerID();
                
        $ReservationID = $this->getReservationID();
        
        $PaymentID = $this->getPaymentID();
        
        $ReservationCode = null;
        
        $PackageRoomInfo = DB::table('tblRoomType as a')
                        ->join('tblPackageRoom as b', 'a.strRoomTypeID', '=', 'b.strPackageRRoomTypeID')
                        ->join('tblRoomRate as c', 'a.strRoomTypeID', '=', 'c.strRoomTypeID')
                        ->select('a.strRoomType',
                                 'a.intRoomTCapacity',
                                 'b.intPackageRQuantity',
                                 'c.dblRoomRate')
                        ->where([['b.strPackageRPackageID', '=', $PackageID], ['c.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")]])
                        ->get();
        

        $ChosenRooms = "";
        foreach($PackageRoomInfo as $Info){
            $ChosenRooms .= $Info -> strRoomType . "-" . $Info -> intRoomTCapacity ."-". $Info -> dblRoomRate ."-".$Info->intPackageRQuantity.",";
        }
        
        $ChosenRooms = rtrim($ChosenRooms,",");
  
        if($Gender == "Male"){
            $Gender = "M";
        }
        else{
            $Gender = "F";
        }
        
        
        if($Remarks == null){
            $Remarks = "N/A";
        }
        
        if($CheckInDate == $CheckOutDate){
            $PickOutTime = "23:59:59";
        }
        
        //save customer data
        $this->saveCustomerData($CustomerID, $FirstName, $MiddleName, $LastName, $Address, $Contact, $Email, $Nationality, $Gender, $Birthday);
        
        //save reservation data
        $ReservationData = array('strReservationID'=>$ReservationID,
                              'intWalkIn'=>'0',
                              'strResDCustomerID'=>$CustomerID,
                              'dtmResDArrival'=>$CheckInDate." ".$PickUpTime,
                              'dtmResDDeparture'=>$CheckOutDate." ".$PickOutTime,
                              'intResDNoOfAdults'=>$NoOfAdults,
                              'intResDNoOfKids'=>$NoOfKids,
                              'strResDRemarks'=>$Remarks,
                              'intResDStatus'=>'4',
                              'dteResDBooking'=>$DateBooked->toDateString(),
                              'strReservationCode'=>$ReservationCode);
        
        DB::table('tblReservationDetail')->insert($ReservationData);
        
        //save reserved rooms
        $CheckInDate2 = $CheckInDate ." ". $PickUpTime;
        $CheckOutDate2 = $CheckOutDate ." ". $PickOutTime;

        $PaymentStatus = 1;
        $this->saveReservedRooms($ChosenRooms, $CheckInDate2, $CheckOutDate2, $ReservationID, $PaymentStatus);
        
        $TransactionData = array('strPaymentID'=>$PaymentID,
                              'strPayReservationID'=>$ReservationID,
                              'dblPayAmount'=>$TotalAmount,
                              'strPayTypeID'=> 3,
                              'dtePayDate'=>$DateBooked->toDateString());
        
        DB::table('tblPayment')->insert($TransactionData);
        
        //Check if there is an entrance fee
        $EntranceFeeID = DB::table('tblFee as a')
                ->join ('tblFeeAmount as b', 'a.strFeeID', '=' , 'b.strFeeID')
                ->select('a.strFeeID')
                ->where([['b.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")],['a.strFeeStatus', '=', 'Active'],['a.strFeeName', '=', 'Entrance Fee']])
                ->pluck('strFeeID')->first();
        
        $EntranceIncluded = DB::table('tblPackageFee')
                            ->where([['strPackageFFeeID', '=', $EntranceFeeID],['strPackageFPackageID', '=', $PackageID]])
                            ->get();
        
        //saves entrance fee
        if(sizeof($EntranceFeeID) != 0){
            if(sizeof($EntranceIncluded) != 0){
                $PaymentStatus = 1;
            }
            $this->addFees($EntranceFeeID, $NoOfAdults, $PaymentStatus, $ReservationID);
        }
        
        $PackageData = array('strAvailPReservationID'=>$ReservationID,
                              'strAvailPackageID'=>$PackageID);
        
        DB::table('tblAvailPackage')->insert($PackageData);
        
        \Session::flash('flash_message','Booked successfully!');
        \Session::flash('ReservationID', $ReservationID);
        return redirect('/ChooseRooms/'.$ReservationID);
    }
    
    public function addWalkInPackage(Request $req){

        $tempCheckInDate = trim($req->input('s-CheckInDate'));
        $tempCheckOutDate = trim($req->input('s-CheckOutDate'));
        $FirstName = trim($req->input('s-FirstName'));
        $MiddleName = trim($req->input('s-MiddleName'));
        $LastName = trim($req->input('s-LastName'));
        $Address = trim($req->input('s-Address'));
        $Email = trim($req->input('s-Email'));
        $Contact = trim($req->input('s-Contact'));
        $Nationality = trim($req->input('s-Nationality'));
        $Gender = trim($req->input('s-Gender'));
        $tempDateOfBirth = trim($req->input('s-DateOfBirth'));
        $InitialBill = trim($req->input('s-InitialBill'));
        $PackageID = trim($req->input('s-PackageID'));
        $Remarks = trim($req->input('s-Remarks'));
        $NoOfKids = trim($req->input('s-NoOfKids'));
        $NoOfAdults = trim($req->input('s-NoOfAdults'));

        $Birthday = Carbon::parse($tempDateOfBirth)->format('Y/m/d');
        $CheckInDate = Carbon::parse($tempCheckInDate)->format('Y/m/d');
        $CheckOutDate = Carbon::parse($tempCheckOutDate)->format('Y/m/d');
        $PickUpTime = Carbon::now()->format('H:i:s');
  
        $PickOutTime = $PickUpTime;
        
        $DateBooked = Carbon::now();
        
        $CustomerID = $this->getCustomerID();
                
        $ReservationID = $this->getReservationID();
        
        $PaymentID = $this->getPaymentID();
        
        $ReservationCode = $this->getReservationCode();
        
        $PackageRoomInfo = DB::table('tblRoomType as a')
                        ->join('tblPackageRoom as b', 'a.strRoomTypeID', '=', 'b.strPackageRRoomTypeID')
                        ->join('tblRoomRate as c', 'a.strRoomTypeID', '=', 'c.strRoomTypeID')
                        ->select('a.strRoomType',
                                 'a.intRoomTCapacity',
                                 'b.intPackageRQuantity',
                                 'c.dblRoomRate')
                        ->where([['b.strPackageRPackageID', '=', $PackageID], ['c.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")]])
                        ->get();
        

        $ChosenRooms = "";
        foreach($PackageRoomInfo as $Info){
            $ChosenRooms .= $Info -> strRoomType . "-" . $Info -> intRoomTCapacity ."-". $Info -> dblRoomRate ."-".$Info->intPackageRQuantity.",";
        }
        
        $ChosenRooms = rtrim($ChosenRooms,",");
  
        if($Gender == "Male"){
            $Gender = "M";
        }
        else{
            $Gender = "F";
        }
        
        
        if($Remarks == null){
            $Remarks = "N/A";
        }
        
        if($CheckInDate == $CheckOutDate){
            $PickOutTime = "23:59:59";
        }
        
        //save customer data
        $this->saveCustomerData($CustomerID, $FirstName, $MiddleName, $LastName, $Address, $Contact, $Email, $Nationality, $Gender, $Birthday);
        
        $ReservationData = array('strReservationID'=>$ReservationID,
                              'intWalkIn'=>'0',
                              'strResDCustomerID'=>$CustomerID,
                              'dtmResDArrival'=>$CheckInDate." ".$PickUpTime,
                              'dtmResDDeparture'=>$CheckOutDate." ".$PickOutTime,
                              'intResDNoOfAdults'=>$NoOfAdults,
                              'intResDNoOfKids'=>$NoOfKids,
                              'strResDRemarks'=>$Remarks,
                              'intResDStatus'=>'4',
                              'dteResDBooking'=>$DateBooked->toDateString(),
                              'strReservationCode'=>$ReservationCode);
        
        DB::table('tblReservationDetail')->insert($ReservationData);
        
        //save reserved rooms
        $CheckInDate2 = $CheckInDate ." ". $PickUpTime;
        $CheckOutDate2 = $CheckOutDate ." ". $PickOutTime;

        $PaymentStatus = 1;
        $this->saveReservedRooms($ChosenRooms, $CheckInDate2, $CheckOutDate2, $ReservationID, $PaymentStatus);
        
        //save reservation transaction payment
        $this->saveReservationTransaction($PaymentID, $ReservationID, $InitialBill, $DateBooked);
        
        //Check if there is an entrance fee
        $EntranceFeeID = DB::table('tblFee as a')
                ->join ('tblFeeAmount as b', 'a.strFeeID', '=' , 'b.strFeeID')
                ->select('a.strFeeID')
                ->where([['b.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")],['a.strFeeStatus', '=', 'Active'],['a.strFeeName', '=', 'Entrance Fee']])
                ->pluck('strFeeID')->first();
        
        $EntranceIncluded = DB::table('tblPackageFee')
                            ->where([['strPackageFFeeID', '=', $EntranceFeeID],['strPackageFPackageID', '=', $PackageID]])
                            ->get();
        
        //saves entrance fee
        if(sizeof($EntranceFeeID) != 0){
            if(sizeof($EntranceIncluded) != 0){
                $PaymentStatus = 1;
            }   
            $this->addFees($EntranceFeeID, $NoOfAdults, $PaymentStatus, $ReservationID);
        }
        
        $PackageData = array('strAvailPReservationID'=>$ReservationID,
                              'strAvailPackageID'=>$PackageID);
        
        DB::table('tblAvailPackage')->insert($PackageData);
        
        \Session::flash('flash_message','Booked successfully!');
        \Session::flash('ReservationID', $ReservationID);
        return redirect('/ChooseRooms/'.$ReservationID);
    }
    
    //Edit rooms
    public function saveChosenRooms(Request $req){
        $ReservationID = trim($req->input('s-ReservationID'));
        $ChosenRooms = json_decode(trim($req->input('s-ChosenRooms')));
        
        $tempArrRooms = "";
        foreach($ChosenRooms as $Rooms){
            $temp = (int)count($Rooms->ChosenRooms);
            for($x = 0; $x < $temp; $x++){
                $tempArrRooms .= DB::table('tblRoom')->where([['strRoomStatus', 'Available'],['strRoomName', $Rooms->ChosenRooms[$x]]])->orderBy('strRoomID')->pluck('strRoomID');
                $tempArrRooms .= ",";
            }
        }
        
        $arrChosenRooms = explode(",", $tempArrRooms);
        array_pop($arrChosenRooms);
        for($x = 0; $x < count($arrChosenRooms); $x++){
            $arrChosenRooms[$x] = str_replace('"', '', $arrChosenRooms[$x]);
            $arrChosenRooms[$x] = str_replace('[', '', $arrChosenRooms[$x]);
            $arrChosenRooms[$x] = str_replace(']', '', $arrChosenRooms[$x]);
        }
        
        $AvailedRooms = DB::table('tblReservationRoom')->where('strResRReservationID', $ReservationID)->orderBy('strResRRoomID')->pluck('strResRRoomID')->toArray();
        $roomFound = false;
   
        //get the difference between two arrays
        $NewRooms = array_diff($arrChosenRooms, $AvailedRooms);
        $OldRooms = array_diff($AvailedRooms, $arrChosenRooms);

        //reset keys of array
        $NewRooms = array_values($NewRooms);
        $OldRooms = array_values($OldRooms);

        //saves array data
        for($x = 0; $x < count($NewRooms); $x++){
        
            $data = array("strResRRoomID" => $NewRooms[$x]);  
            
            DB::table('tblReservationRoom')
            ->where([['strResRRoomID', $OldRooms[$x]], ['strResRReservationID', $ReservationID]])
            ->update($data);
        
        }
        
        \Session::flash('flash_message','Saved successfully!');
         return redirect('/Rooms');
    }
    
    //saves new fees to the database
    public function saveFees($FeeName, $FeeAmount){
        $FeeID = $this->SmartCounter('tblFee', 'strFeeID');
        $DateCreated = Carbon::now();
        
        $InactiveFees = DB::table('tblFee as a')
                ->join ('tblFeeAmount as b', 'a.strFeeID', '=' , 'b.strFeeID')
                ->select('a.strFeeID')
                ->where([['b.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")],['a.strFeeStatus', '=', 'Inactive'], ['strFeeName', '=', $FeeName]])
                ->get();
        
   
        if(sizeof($InactiveFees) == 0){
            $data = array('strFeeID'=>$FeeID,
                     'strFeeName'=>$FeeName,
                     'strFeeStatus'=>'Active',
                     'strFeeDescription'=>"N/A",
                     'tmsCreated'=>$DateCreated);

            DB::table('tblFee')->insert($data);

            $dataAmount = array('strFeeID'=>$FeeID,
                         'dblFeeAmount'=>$FeeAmount,
                         'dtmFeeAmountAsOf'=>$DateCreated);

            DB::table('tblFeeAmount')->insert($dataAmount);
        }
        else{
            $updateData = array("strFeeStatus" => "Active");  
            
            DB::table('tblFee')
            ->where('strFeeName', $FeeName)
            ->update($updateData);
            
            $InactiveFeeID;
            foreach($InactiveFees as $Fee){
                $InactiveFeeID = $Fee->strFeeID;
            }
            
            $dataAmount = array('strFeeID'=>$InactiveFeeID,
                         'dblFeeAmount'=>$FeeAmount,
                         'dtmFeeAmountAsOf'=>$DateCreated);

            DB::table('tblFeeAmount')->insert($dataAmount);
        }
    }
    
    //add fees to customer's bill
    public function addFees($FeeID, $FeeQuantity, $PaymentStatus, $ReservationID){
        
        $ExistingFeeQuantity = DB::table('tblReservationFee')
                ->select('intResFQuantity')
                ->where([['strResFFeeID','=', $FeeID], ['strResFReservationID','=', $ReservationID]])
                ->pluck('intResFQuantity')->first();
        
        if(sizeof($ExistingFeeQuantity) == 0){
            $data = array('strResFReservationID'=>$ReservationID,
                          'strResFFeeID'=>$FeeID,
                          'intResFPayment'=>$PaymentStatus,
                          'intResFQuantity'=>$FeeQuantity);

            DB::table('tblReservationFee')->insert($data);
        }
        else{
            $newQuantity = (int)$ExistingFeeQuantity + (int)$FeeQuantity;

            $updateData = array("intResFQuantity" => $newQuantity);   
        
            DB::table('tblReservationFee')
                ->where([['strResFFeeID', $FeeID], ['strResFReservationID', $ReservationID]])
                ->update($updateData);
        }
    }
    

}
