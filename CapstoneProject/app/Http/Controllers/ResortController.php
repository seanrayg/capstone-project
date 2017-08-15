<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use DatePeriod;
use DateInterval;

class ResortController extends Controller
{
    //
    
    /* ITEM REFERENCE 
    
    intRentedIReturned
    
    0 = not returned
    1 = returned
    
    intRentedIBroken
    0 = not broken
    1 = Broken
    
    intRentedIPayment
    0 = not paid
    1 = paid
    */
    
    
    /*------------ ITEM RENTAL -------------*/
    
    //rent item
    public function storeRentalItem(Request $req){

        $ItemID = trim($req->input('RentItemID'));
        $CustomerName = trim($req->input('SelectGuests'));
        $RentQuantity = trim($req->input('RentQuantity'));
        $RentDuration = trim($req->input('RentDuration'));
        $PaymentStatus = 0;
        
        $ReservationID = DB::table('tblReservationDetail as a')
                        ->join ('tblCustomer as b', 'a.strResDCustomerID', '=' , 'b.strCustomerID')
                        ->where([['a.intResDStatus', '=', '4'],[DB::raw('CONCAT(b.strCustFirstName , " " , b.strCustLastName)'),'=',$CustomerName]])
                        ->pluck('a.strReservationID')
                        ->first();
        
        $RentedItems = DB::table('tblrenteditem')->get();
    
        $RentItemID;
        if(sizeof($RentedItems) == 0){
            $RentItemID = "RENT1";
        }
        else{
            $RentItemID = $this->SmartCounter('tblrenteditem', 'strRentedItemID');
        }
        
        $dt = Carbon::now('HongKong');
        $TimeToday = $dt->toTimeString(); 
        $DateToday = $dt->toDateString();
        $TimeRented = $DateToday." ".$TimeToday;
        //save Rented item
        
        $data = array('strRentedItemID'=>$RentItemID,
                     'strRentedIReservationID'=>$ReservationID,
                     'strRentedIItemID'=>$ItemID,
                     'intRentedIReturned'=>0,
                     'intRentedIQuantity'=>$RentQuantity,
                     'intRentedIDuration'=>$RentDuration,
                     'intRentedIBroken'=>0,
                     'intRentedIPayment'=>$PaymentStatus,
                     'tmsCreated'=>$TimeRented);
        
        DB::table('tblRentedItem')->insert($data);
        
        \Session::flash('flash_message','Successfully rented the item!');
        
        return redirect('ItemRental');
    }
    
    
    /*----------- MISC ----------------*/
    
    //SmartCounter
    
    public function SmartCounter($strTableName, $strColumnName){
        $endLoop = false;
        $latestID = DB::table($strTableName)->where('tmsCreated', DB::raw("(SELECT max(tmsCreated) FROM ".$strTableName.")"))->pluck($strColumnName)->first();
        
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
