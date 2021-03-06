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
        
        $CustomerID = $this->getCustomerID($FirstName, $MiddleName, $LastName, $Birthday, $Gender);
                
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
            
        return redirect('/Reservation/'.$ReservationID);
    }

    public function addReservationPackage(Request $req){

        $tempCheckInDate = trim($req->input('s-CheckInDate'));
        $tempCheckOutDate = trim($req->input('s-CheckOutDate'));
        $tempPickUpTime = trim($req->input('s-PickUpTime'));
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
        $Remarks = trim($req->input('s-Remarks'));
        $NoOfKids = trim($req->input('s-NoOfKids'));
        $NoOfAdults = trim($req->input('s-NoOfAdults'));
        $PackageName = trim($req->input('s-PackageName'));

        $Birthday = Carbon::parse($tempDateOfBirth)->format('Y/m/d');
        $CheckInDate = Carbon::parse($tempCheckInDate)->format('Y/m/d');
        $CheckOutDate = Carbon::parse($tempCheckOutDate)->format('Y/m/d');
        $PickUpTime = Carbon::parse($tempPickUpTime)->format('H:i:s');
        $PickUpTime2 = Carbon::parse($tempPickUpTime)->addHours(1)->format('H:i:s');

        if($Gender == "Male"){
            $Gender = "M";
        }
        else{
            $Gender = "F";
        }
        
  
        $PickOutTime = $PickUpTime;
        
        $DateBooked = Carbon::now();
        
        $CustomerID = $this->getCustomerID($FirstName, $MiddleName, $LastName, $Birthday, $Gender);
                
        $ReservationID = $this->getReservationID();
        
        $PaymentID = $this->getPaymentID();
        
        $ReservationCode = $this->getReservationCode();

        $PackageID = DB::table('tblPackage')->where([['strPackageName','=', $PackageName],['strPackageStatus', '=', 'Available']])->pluck('strPackageID')->first();
        
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
        /*if($BoatsUsed != null){
               $this->saveReservedBoats($ReservationID, $CheckInDate, $CheckOutDate, $PickUpTime, $PickUpTime2, $BoatsUsed);          
        }*/
        
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
        
        /*\Session::flash('flash_message','Reservation successfully booked! The reservation code of '. $FirstName . ' ' . $LastName . ' is ' . $ReservationCode.'.');
         return redirect('/Reservations');*/
        return redirect('/ChooseRooms/'.$ReservationID);
    }

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
        
         return redirect('/');
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
                                         'strBoatSReservationID' => $ReservationID,
                                         'intBoatSPayment' => 0);

            DB::table('tblBoatSchedule')->insert($InsertBoatSchedData);  

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

        $newCustomer = DB::table('tblCustomer')->where('strCustomerID', '=', $CustomerID)->get();


        if(sizeof($newCustomer) == 0){
            DB::table('tblCustomer')->insert($CustomerData);
        }
        else{
            DB::table('tblCustomer')
            ->where('strCustomerID', $CustomerID)
            ->update($updateData);
        }
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

    public function getCustomerID($FirstName, $MiddleName, $LastName, $Birthday, $Gender){
        $CustomerID = DB::table('tblCustomer')->pluck('strCustomerID')->first();
        $Birthday = Carbon::parse($Birthday)->format('Y-m-d');
        $ExistingCustomerID = DB::table('tblCustomer')
                            ->where([['strCustFirstName', '=', $FirstName],['strCustLastName', '=', $LastName], ['strCustMiddleName', '=', $MiddleName], ['dtmCustBirthday', '=', $Birthday], ['strCustGender', '=', $Gender]])
                            ->pluck('strCustomerID')
                            ->first();

        if(!$CustomerID){
            return "CUST1";
        }
        else if($ExistingCustomerID){
            return $ExistingCustomerID;
        }
        else{
            $CustomerID = $this->SmartCounter('tblCustomer', 'strCustomerID');
            return $CustomerID;
        }
        
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

    public function saveDepositSlip(Request $req){

        $DepositSlip = Input::file('depositSlip');
        $ReservationID = $req->input("DepositReservationID");
        
        //set ilsognowebsite path
        $SystemPath = public_path("DepositSlips");
        $SystemPath = str_replace('IlSognoWebsite', 'CapstoneProject', $SystemPath);
        $SystemPath = $SystemPath . "/";
        
        //save image to capstoneproject
        $req->file('depositSlip')->move("DepositSlips", $DepositSlip->getClientOriginalName());
        
        //save image to ilsognowebsite
        copy(public_path("DepositSlips/").$DepositSlip->getClientOriginalName(), $SystemPath.$DepositSlip->getClientOriginalName());  
    
  
        $DepositSlipPath = "/DepositSlips/" . $DepositSlip->getClientOriginalName();
    
        $updateData = array("strResDDepositSlip" => $DepositSlipPath);   
        
        DB::table('tblReservationDetail')
            ->where('strReservationID', '=', $ReservationID)
            ->update($updateData);
    
        \Session::flash('flash_message','Successfully uploaded the deposit slip!');
        return redirect('/Reservation/'.$ReservationID);
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
}
