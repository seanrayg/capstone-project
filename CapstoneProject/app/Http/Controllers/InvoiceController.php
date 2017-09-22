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

        $dtmNow = Carbon::now('Asia/Manila');
        $dateNow = $dtmNow->toFormattedDateString();
        $intTotal = 0;

        $boolIsPackaged;

        $InvoiceNumber = $dtmNow->year;

        if($intIsPackaged == 0) {

            $boolIsPackaged = false;

        }else if($intIsPackaged == 1) {

            $boolIsPackaged = true;

        }

        if($strInvoiceType == 'Reservation') {

            if($boolIsPackaged) {

                
                
            }else {

                $CustomerName = DB::table('tblReservationDetail as a')
                    ->join('tblCustomer as b', 'a.strResDCustomerID', '=', 'b.strCustomerID')
                    ->select(
                        DB::raw("CONCAT(b.strCustFirstName, ' ', b.strCustLastName) as name"))
                    ->where('a.strReservationID', '=', $strReservationID)
                    ->first();

                $CustomerName = $CustomerName->name;

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

                foreach ($rooms as $room) {
                    
                    $room->strRoomType = "Room " . $room->strRoomType;
                    $intTotal += $room->amount;

                }

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

                foreach ($EntranceFee as $ef) {
                    
                    $intTotal += $ef->amount;

                }

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

                foreach ($ChosenBoats as $boat) {
                    
                    $intTotal += $boat->amount;

                }

                $pdf = PDF::loadview('pdf.invoice', ['CustomerName' => $CustomerName, 'date' => $dateNow, 'total' => $intTotal, 'InvoiceType' => $strInvoiceType, 'rooms' => $rooms, 'fees' => $EntranceFee, 'boats' => $ChosenBoats]);
                return $pdf->stream();

            }

        }

    }
}
