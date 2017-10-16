<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use PDF;

class InvoiceController extends Controller
{
    
	public function GenerateInvoice(Request $request) {

		$strInvoiceType = $request->input('InvoiceType');

        $dtmNow = Carbon::now('Asia/Manila');
        $dateNow = $dtmNow->toFormattedDateString();

        $TableRows = 0;

        $intTotal = 0;

		if($strInvoiceType == 'BookReservation') {

			$intDaysOfStay = $request->input("DaysOfStay");
            $tblRoomInfo = $request->input("tblRoomInfo");
            $tblFeeInfo = $request->input("tblFeeInfo");
            $strCustomerName = $request->input("iCustomerName");
            $strCustomerAddress = $request->input("iCustomerAddress");
            $intTotalAdults = $request->input("iTotalAdults");
            $BoatsUsed = $request->input("iBoats");

            if($intDaysOfStay == 0) {

                $intDaysOfStay = 1;

            }

            $ReservationID = $this->SmartCounter("tblReservationDetail", "strReservationID");
            $InvoiceNumber = $this->GetInvoiceNumber($strInvoiceType, $ReservationID);

            $tblRoomInfo = json_decode($tblRoomInfo);

            $rooms = array();

            for ($i = 1; $i < count($tblRoomInfo); $i++) {

                $tblRoomInfo[$i][3] = $tblRoomInfo[$i][3] * $intDaysOfStay;

                array_push($rooms, (object) ['name' => $tblRoomInfo[$i][0], 'price' => $tblRoomInfo[$i][1], 'quantity' => $tblRoomInfo[$i][2], 'amount' => $tblRoomInfo[$i][3]]);
                $TableRows++;

            }

            $intTotal = $this->GetTotal($intTotal, $rooms);

            $amount = 100 * $intTotalAdults;

            $EntranceFee = array(
                (object) array("name" => "Entrance Fee", "price" => "100", "quantity" => $intTotalAdults, "amount" => $amount)
            );
            $TableRows++;

            $intTotal = $this->GetTotal($intTotal, $EntranceFee);

            $Boats = array();

            if($BoatsUsed != '0') {

                $dblBoatPrice = $request->input('iBoatsAmount');

                $Boats = array(
                    (object) array("name" => "Boats: " . $BoatsUsed, "price" => $dblBoatPrice, "quantity" => '-', "amount" => $dblBoatPrice)
                );
                $TableRows++;

                $intTotal = $this->GetTotal($intTotal, $Boats);

            }

            $pdf = PDF::loadview('pdf.invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $strCustomerName, 'CustomerAddress' => $strCustomerAddress, 'days' => $intDaysOfStay, 'date' => $dateNow, 'total' => $intTotal, 'InvoiceType' => $strInvoiceType, 'TableRows' => $TableRows, 'rooms' => $rooms, 'EntranceFee' => $EntranceFee, 'boats' => $Boats]);
            return $pdf->stream();

		}

	}

	public function GetTotal($intTotal, $items) {

        foreach ($items as $item) {
            
            $intTotal += $item->amount;

        }

        return $intTotal;

    }

    public function GetInvoiceNumber($InvoiceType, $ID) {

        $dtmNow = Carbon::now('Asia/Manila');
        $dateNow = $dtmNow->toFormattedDateString();

        $InvoiceNumber = $dtmNow->year;
        $ID = $this->GetNumber($ID);

        if($InvoiceType == 'BookReservation') {

            $InvoiceNumber .= "18" . $ID;

            return $InvoiceNumber;

        }

    }

    public function GetNumber($ID) {

        $tempArr =  str_split($ID);
        $intNumber = "";

        for($i = 0; $i < count($tempArr); $i++) {

            if(is_numeric($tempArr[$i])) {

                $intNumber .= $tempArr[$i];

            }

        }

        if(strlen($intNumber) == 1) {

            $intNumber = "000" . $intNumber;

        }else if(strlen($intNumber) == 2) {

            $intNumber = "00" . $intNumber;

        }if(strlen($intNumber) == 3) {

            $intNumber = "0" . $intNumber;

        }

        return $intNumber;

    }

    public function GetCustomerInfo($ID, $TYPE) {

        if($TYPE == 'ReservationID') {

            $CustomerName = DB::table('tblReservationDetail as a')
                ->join('tblCustomer as b', 'a.strResDCustomerID', '=', 'b.strCustomerID')
                ->select(
                    DB::raw("CONCAT(b.strCustFirstName, ' ', b.strCustLastName) as name"),
                    'b.strCustAddress')
                ->where('a.strReservationID', '=', $ID)
                ->first();

            $CustomerInfo = array($CustomerName->strCustAddress, $CustomerName->name);
            
            return $CustomerInfo;

        }else if($TYPE == 'CustomerID') {

            $CustomerName = DB::table('tblCustomer')
                ->select(
                    DB::raw("CONCAT(strCustFirstName, ' ', strCustLastName) as name"),
                    'strCustAddress')
                ->where('strCustomerID', '=', $ID)
                ->first();

            $CustomerInfo = array($CustomerName->strCustAddress, $CustomerName->name);
            
            return $CustomerInfo;

        }

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
