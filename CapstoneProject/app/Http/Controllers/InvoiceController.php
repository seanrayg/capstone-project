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
        $strReservationID = $request->input('ReservationID');
        $intIsPackaged = $request->input('IsPackaged');

        $CustomerName = DB::table('tblReservationDetail as a')
            ->join('tblCustomer as b', 'a.strResDCustomerID', '=', 'b.strCustomerID')
            ->select(
                DB::raw("CONCAT(b.strCustFirstName, ' ', b.strCustLastName) as name"),
                'b.strCustAddress')
            ->where('a.strReservationID', '=', $strReservationID)
            ->first();

        $CustomerAddress = $CustomerName->strCustAddress;
        $CustomerName = $CustomerName->name;

        $dtmNow = Carbon::now('Asia/Manila');
        $dateNow = $dtmNow->toFormattedDateString();

        $intTotal = 0;

        $boolIsPackaged;

        if($intIsPackaged == 0) {

            $boolIsPackaged = false;

        }else if($intIsPackaged == 1) {

            $boolIsPackaged = true;

        }

        if($strInvoiceType == 'Reservation') {

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

                $intTotal = $this->GetTotal($intTotal, $Packages);

                $pdf = PDF::loadview('pdf.invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $CustomerName, 'CustomerAddress' => $CustomerAddress, 'date' => $dateNow, 'total' => $intTotal, 'InvoiceType' => $strInvoiceType, 'boolIsPackaged' => true, 'packages' => $Packages]);
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

                $intTotal = $this->GetTotal($intTotal, $ChosenBoats);

                $pdf = PDF::loadview('pdf.invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $CustomerName, 'CustomerAddress' => $CustomerAddress, 'date' => $dateNow, 'total' => $intTotal, 'InvoiceType' => $strInvoiceType,'boolIsPackaged' => false, 'rooms' => $rooms, 'fees' => $EntranceFee, 'boats' => $ChosenBoats]);
                return $pdf->stream();

            }

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
}
