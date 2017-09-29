<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function GenerateInvoice(Request $request) {

        $strInvoiceType = $request->input('InvoiceType');

        $dtmNow = Carbon::now('Asia/Manila');
        $dateNow = $dtmNow->toFormattedDateString();

        $TableRows = 0;

        $intTotal = 0;

        if($strInvoiceType == 'Reservation') {

            $strReservationID = $request->input('ReservationID');

            $CustomerInfo = $this->GetCustomerInfo($strReservationID, "ReservationID");

            $CustomerAddress = $CustomerInfo[0];
            $CustomerName = $CustomerInfo[1];

            $intIsPackaged = $request->input('IsPackaged');

            $boolIsPackaged;

            if($intIsPackaged == 0) {

                $boolIsPackaged = false;

            }else if($intIsPackaged == 1) {

                $boolIsPackaged = true;

            }

            $InvoiceNumber = $this->GetInvoiceNumber($strInvoiceType, $strReservationID);

            if($boolIsPackaged) {

                $Packages = DB::table('tblAvailPackage as a')
                    ->join('tblPackage as b', 'a.strAvailPackageID', '=', 'b.strPackageID')
                    ->join('tblPackagePrice as c', 'b.strPackageID', '=', 'c.strPackageID')
                    ->select(
                        'b.strPackageName',
                        'c.dblPackagePrice',
                        DB::raw("COUNT(b.strPackageName) as quantity"),
                        DB::raw("(COUNT(b.strPackageName) * c.dblPackagePrice) as amount"))
                    ->where([['a.strAvailPReservationID' , '=', $strReservationID], ['c.dtmPackagePriceAsOf', '=' , DB::raw("(SELECT max(dtmPackagePriceAsOf) FROM tblPackagePrice WHERE strPackageID = c.strPackageID)")]])
                    ->groupBy('b.strPackageName', 'c.dblPackagePrice')
                    ->get();

                foreach ($Packages as $Package) {
                    $TableRows++;
                }

                $intTotal = $this->GetTotal($intTotal, $Packages);

                $pdf = PDF::loadview('pdf.invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $CustomerName, 'CustomerAddress' => $CustomerAddress, 'date' => $dateNow, 'total' => $intTotal, 'TableRows' => $TableRows, 'InvoiceType' => $strInvoiceType, 'boolIsPackaged' => true, 'packages' => $Packages]);
                return $pdf->stream();
                
            }else {

                $rooms = DB::table('tblReservationRoom as a')
                    ->join('tblRoom as b', 'a.strResRRoomID', '=', 'b.strRoomID')
                    ->join('tblRoomType as c', 'b.strRoomTypeID', '=', 'c.strRoomTypeID')
                    ->join('tblRoomRate as d', 'c.strRoomTypeID', '=', 'd.strRoomTypeID')
                    ->select(
                        'c.strRoomType',
                        DB::raw('COUNT(c.strRoomType) as quantity'),
                        'd.dblRoomRate',
                        DB::raw('(COUNT(c.strRoomType) * d.dblRoomRate) as amount'))
                    ->where([['a.strResRReservationID', '=', $strReservationID], ['d.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = d.strRoomTypeID)")]])
                    ->groupBy('c.strRoomType', 'd.dblRoomRate')
                    ->get();

                $days = DB::table('tblReservationDetail')
                    ->select(DB::raw("TIMESTAMPDIFF(DAY,dtmResDArrival,dtmResDDeparture) as days"))
                    ->where('strReservationID', '=', $strReservationID)
                    ->first();

                foreach ($rooms as $room) {
                    $room->strRoomType = "Room " . $room->strRoomType;
                    $room->quantity = $days->days;
                    $room->amount = $room->dblRoomRate * $room->quantity;
                    $TableRows++;
                }

                $intTotal = $this->GetTotal($intTotal, $rooms);

                $customer = DB::table('tblReservationDetail')
                    ->select(
                        'intResDNoOfAdults',
                        'intResDNoOfKids')
                    ->where('strReservationID', '=', $strReservationID)
                    ->first();

                $NumberOfCustomers = $customer->intResDNoOfAdults + $customer->intResDNoOfKids;
                $amount = $NumberOfCustomers * 100;

                $EntranceFee = array(
                    (object) array("name" => "Entrance Fee", "price" => "100", "quantity" => $NumberOfCustomers, "amount" => $amount)
                );
                $TableRows++;

                $intTotal = $this->GetTotal($intTotal, $EntranceFee);

                $ChosenBoats = DB::table('tblReservationBoat as a')
                    ->join('tblBoat as b', 'a.strResBBoatID', '=' , 'b.strBoatID')
                    ->join('tblBoatRate as c', 'b.strBoatID', '=', 'c.strBoatID')
                    ->select(
                        'b.strBoatName',
                        'c.dblBoatRate',
                        DB::raw('COUNT(b.strBoatName) as quantity'),
                        DB::raw('(COUNT(b.strBoatName) * c.dblBoatRate) as amount'))
                    ->where([['a.strResBReservationID', "=", $strReservationID], ['c.dtmBoatRateAsOf', '=', DB::raw("(SELECT max(dtmBoatRateAsOf) FROM tblBoatRate WHERE strBoatID = b.strBoatID)")]])
                    ->groupBy('b.strBoatName', 'c.dblBoatRate')
                    ->get();

                foreach ($ChosenBoats as $ChosenBoat) {
                    $TableRows++;
                }

                $intTotal = $this->GetTotal($intTotal, $ChosenBoats);

                $pdf = PDF::loadview('pdf.invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $CustomerName, 'CustomerAddress' => $CustomerAddress, 'date' => $dateNow, 'total' => $intTotal, 'InvoiceType' => $strInvoiceType, 'TableRows' => $TableRows, 'boolIsPackaged' => false, 'rooms' => $rooms, 'fees' => $EntranceFee, 'boats' => $ChosenBoats]);
                return $pdf->stream();

            }

        }else if($strInvoiceType == 'BoatRental') {

            $name = "Boat Rental";
            $price = $request->input('Rate');
            $quantity = $request->input('Hours');
            $amount = $request->input('Amount');
            $CustomerID = $request->input('CustomerID');

            $CustomerInfo = $this->GetCustomerInfo($CustomerID, "CustomerID");

            $CustomerAddress = $CustomerInfo[0];
            $CustomerName = $CustomerInfo[1];

            $BoatScheduleID = $this->SmartCounter("tblBoatSchedule", "strBoatScheduleID");
            $InvoiceNumber = $this->GetInvoiceNumber($strInvoiceType, $BoatScheduleID);

            $RentalBoats = array(
                (object) array("name" => $name, "price" => $price, "quantity" => $quantity, "amount" => $amount)
            );
            $TableRows++;

            $intTotal = $this->GetTotal($intTotal, $RentalBoats);

            $pdf = PDF::loadview('pdf.service_invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $CustomerName, 'CustomerAddress' => $CustomerAddress, 'date' => $dateNow, 'InvoiceType' => $strInvoiceType, 'total' => $intTotal, 'TableRows' => $TableRows, 'RentalBoats' => $RentalBoats])->setPaper('A6', 'portrait');
            return $pdf->stream();

        }

    }//End of GenerateInvoice

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

        if($InvoiceType == 'Reservation') {

            $InvoiceNumber .= "18" . $ID;

            return $InvoiceNumber;

        }else if($InvoiceType == 'BoatRental') {

            $InvoiceNumber .= "219" . $ID;

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
