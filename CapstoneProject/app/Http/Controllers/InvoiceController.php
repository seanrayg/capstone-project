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
        $dblAmountTendered = $request->input('iAmountTendered');

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

            $days = DB::table('tblReservationDetail')
                ->select(DB::raw("TIMESTAMPDIFF(DAY,dtmResDArrival,dtmResDDeparture) as days"))
                ->where('strReservationID', '=', $strReservationID)
                ->first();

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

                $pdf = PDF::loadview('pdf.invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $CustomerName, 'CustomerAddress' => $CustomerAddress, 'date' => $dateNow, 'total' => $intTotal, 'TableRows' => $TableRows, 'days' => $days->days, 'InvoiceType' => $strInvoiceType, 'boolIsPackaged' => true, 'packages' => $Packages]);
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

                foreach ($rooms as $room) {
                    $room->strRoomType = "Room " . $room->strRoomType;
                    $room->amount = $room->dblRoomRate * $room->quantity * $days->days;
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

                $pdf = PDF::loadview('pdf.invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $CustomerName, 'CustomerAddress' => $CustomerAddress, 'date' => $dateNow, 'total' => $intTotal, 'InvoiceType' => $strInvoiceType, 'TableRows' => $TableRows, 'days' => $days->days, 'boolIsPackaged' => false, 'rooms' => $rooms, 'fees' => $EntranceFee, 'boats' => $ChosenBoats]);
                return $pdf->stream();

            }

        }else if($strInvoiceType == 'WalkIn') {

            $intDaysOfStay = $request->input("DaysOfStay");
            $tblRoomInfo = $request->input("tblRoomInfo");
            $tblFeeInfo = $request->input("tblFeeInfo");
            $strCustomerName = $request->input("iCustomerName");
            $strCustomerAddress = $request->input("iCustomerAddress");
            $intTotalAdults = $request->input("iTotalAdults");

            $ReservationID = $this->SmartCounter("tblReservationDetail", "strReservationID");
            $InvoiceNumber = $this->GetInvoiceNumber($strInvoiceType, $ReservationID);

            $tblRoomInfo = json_decode($tblRoomInfo);
            $tblFeeInfo = json_decode($tblFeeInfo);

            $rooms = array();
            $fees = array();

            for ($i = 1; $i < count($tblRoomInfo); $i++) {

                $tblRoomInfo[$i][3] = $tblRoomInfo[$i][3] * $intDaysOfStay;

                array_push($rooms, (object) ['name' => $tblRoomInfo[$i][0], 'price' => $tblRoomInfo[$i][1], 'quantity' => $tblRoomInfo[$i][2], 'amount' => $tblRoomInfo[$i][3]]);
                $TableRows++;

            }

            $intTotal = $this->GetTotal($intTotal, $rooms);

            for ($i = 1; $i < count($tblFeeInfo); $i++) {

                if($tblFeeInfo[$i][0] == 'Entrance Fee') {

                    $tblFeeInfo[$i][0] = 'Added Entrance Fee';

                }

                array_push($fees, (object) ['name' => $tblFeeInfo[$i][0], 'price' => $tblFeeInfo[$i][1], 'quantity' => $tblFeeInfo[$i][2], 'amount' => $tblFeeInfo[$i][3]]);
                $TableRows++;

            }

            $intTotal = $this->GetTotal($intTotal, $fees);

            $amount = 100 * $intTotalAdults;

            $EntranceFee = array(
                (object) array("name" => "Entrance Fee", "price" => "100", "quantity" => $intTotalAdults, "amount" => $amount)
            );
            $TableRows++;

            $intTotal = $this->GetTotal($intTotal, $EntranceFee);

            $pdf = PDF::loadview('pdf.invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $strCustomerName, 'CustomerAddress' => $strCustomerAddress, 'days' => $intDaysOfStay, 'date' => $dateNow, 'total' => $intTotal, 'payment' => $dblAmountTendered, 'InvoiceType' => $strInvoiceType, 'TableRows' => $TableRows, 'rooms' => $rooms, 'fees' => $fees, 'EntranceFee' => $EntranceFee]);
            return $pdf->stream();

        }else if($strInvoiceType == 'WalkInPackage') {

            $strPackageName = $request->input('PackageName');
            $dblPackagePrice = $request->input('PackagePrice');
            $intNoOfAdults = $request->input('NoOfAdults');
            $strCustomerName = $request->input('CustomerName');
            $strCustomerAddress = $request->input('CustomerAddress');
            $intDaysOfStay = $request->input('intDaysOfStay');

            $ReservationID = $this->SmartCounter("tblReservationDetail", "strReservationID");
            $InvoiceNumber = $this->GetInvoiceNumber($strInvoiceType, $ReservationID);

            $Package = array(
                (object) array("name" => $strPackageName, "price" => $dblPackagePrice, "quantity" => 1, "amount" => $dblPackagePrice * 1)
            );
            $TableRows++;

            if($intNoOfAdults != 0) {

                array_push($Package, (object) ["name" => "Entrance Fee", "price" => 100, "quantity" => $intNoOfAdults, "amount" => 100 * $intNoOfAdults]);
                $TableRows++;

            }

            $intTotal = $this->GetTotal($intTotal, $Package);

            $pdf = PDF::loadview('pdf.invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $strCustomerName, 'CustomerAddress' => $strCustomerAddress, 'days' => $intDaysOfStay, 'date' => $dateNow, 'total' => $intTotal, 'payment' => $dblAmountTendered, 'InvoiceType' => $strInvoiceType, 'TableRows' => $TableRows, 'package' => $Package]);
            return $pdf->stream();

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

            $pdf = PDF::loadview('pdf.service_invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $CustomerName, 'CustomerAddress' => $CustomerAddress, 'date' => $dateNow, 'InvoiceType' => $strInvoiceType, 'total' => $intTotal, 'payment' => $dblAmountTendered, 'TableRows' => $TableRows, 'RentalBoats' => $RentalBoats])->setPaper('A6', 'portrait');
            return $pdf->stream();

        }else if($strInvoiceType == 'UpgradeRoom') {

            $ReservationID = $request->input('iReservationID');
            $Description = $request->input('Description');
            $ORoomType = $request->input('iOrigRoomType');
            $RoomType = $request->input('iRoomType');
            $Amount = $request->input('Amount');

            $CustomerInfo = $this->GetCustomerInfo($ReservationID, "ReservationID");

            $CustomerAddress = $CustomerInfo[0];
            $CustomerName = $CustomerInfo[1];

            $UpgradeRoomType = DB::table('tblRoomType as a')
                ->join('tblRoomRate as b', 'a.strRoomTypeID', '=', 'b.strRoomTypeID')
                ->select('b.dblRoomRate')
                ->where([['a.strRoomType', '=', $RoomType], ['b.dtmRoomRateAsOf', '=', DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")]])
                ->first();

            $OrigRoomType = DB::table('tblRoomType as a')
                ->join('tblRoomRate as b', 'a.strRoomTypeID', '=', 'b.strRoomTypeID')
                ->select('b.dblRoomRate')
                ->where([['a.strRoomType', '=', $ORoomType], ['b.dtmRoomRateAsOf', '=', DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")]])
                ->first();

            $days = DB::table('tblReservationDetail')
                ->select(DB::raw("TIMESTAMPDIFF(DAY,NOW(),dtmResDDeparture) as days"))
                ->where('strReservationID', '=', $ReservationID)
                ->first();

            $RoomPaid = DB::table('tblReservationRoom')
                ->select('intResRPayment')
                ->where ('strResRReservationID', '=', $ReservationID)
                ->first();

            if($RoomPaid->intResRPayment == 1) {

                $UpgradeRoomType->dblRoomRate = $UpgradeRoomType->dblRoomRate - $OrigRoomType->dblRoomRate;

            }

            $UpgradeRooms = array(
                (object) array("name" => $Description, "price" => $UpgradeRoomType->dblRoomRate, "quantity" => $days->days, "amount" => $Amount)
            );
            $TableRows++;

            $intTotal = $this->GetTotal($intTotal, $UpgradeRooms);

            $BoatScheduleID = $this->SmartCounter("tblPayment", "strPaymentID");
            $InvoiceNumber = $this->GetInvoiceNumber($strInvoiceType, $BoatScheduleID);

            $pdf = PDF::loadview('pdf.service_invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $CustomerName, 'CustomerAddress' => $CustomerAddress, 'date' => $dateNow, 'InvoiceType' => $strInvoiceType, 'total' => $intTotal, 'payment' => $dblAmountTendered, 'TableRows' => $TableRows, 'UpgradeRooms' => $UpgradeRooms])->setPaper('A6', 'portrait');
            return $pdf->stream();

        }else if($strInvoiceType == 'Fees') {

            $ReservationID = $request->input('iReservationID');
            $FeeID = $request->input('FeeID');
            $Quantity = $request->input('Quantity');
            $Amount = $request->input('Amount');

            $FeeInfo = DB::table('tblFee as a')
                ->join('tblFeeAmount as b', 'a.strFeeID', '=', 'b.strFeeID')
                ->select(
                    'a.strFeeName',
                    'b.dblFeeAmount')
                ->where([['a.strFeeID', '=', $FeeID],['b.dtmFeeAmountAsOf', '=', DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")]])
                ->first();

            $Description = $FeeInfo->strFeeName;
            $Price = $FeeInfo->dblFeeAmount;

            $CustomerInfo = $this->GetCustomerInfo($ReservationID, "ReservationID");

            $CustomerAddress = $CustomerInfo[0];
            $CustomerName = $CustomerInfo[1];

            $Fees = array(
                (object) array("name" => $Description, "price" => $Price, "quantity" => $Quantity, "amount" => $Amount)
            );
            $TableRows++;

            $intTotal = $this->GetTotal($intTotal, $Fees);

            $BoatScheduleID = $this->SmartCounter("tblReservationFee", "strResFReservationID");
            $InvoiceNumber = $this->GetInvoiceNumber($strInvoiceType, $BoatScheduleID);

            $pdf = PDF::loadview('pdf.service_invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $CustomerName, 'CustomerAddress' => $CustomerAddress, 'date' => $dateNow, 'InvoiceType' => $strInvoiceType, 'total' => $intTotal, 'payment' => $dblAmountTendered, 'TableRows' => $TableRows, 'Fees' => $Fees])->setPaper('A6', 'portrait');
            return $pdf->stream();

        }else if($strInvoiceType == 'ExtendStay') {

            $ReservationID = $request->input('iReservationID');
            $DaysOfExtend = $request->input('DaysOfExtend');

            $CustomerInfo = $this->GetCustomerInfo($ReservationID, "ReservationID");

            $CustomerAddress = $CustomerInfo[0];
            $CustomerName = $CustomerInfo[1];

            $InvoiceNumber = $this->GetInvoiceNumber($strInvoiceType, $ReservationID);

            $rooms = DB::table('tblReservationRoom as a')
                ->join('tblRoom as b', 'a.strResRRoomID', '=', 'b.strRoomID')
                ->join('tblRoomType as c', 'b.strRoomTypeID', '=', 'c.strRoomTypeID')
                ->join('tblRoomRate as d', 'c.strRoomTypeID', '=', 'd.strRoomTypeID')
                ->select(
                    'c.strRoomType',
                    DB::raw('COUNT(c.strRoomType) as quantity'),
                    'd.dblRoomRate',
                    DB::raw('(COUNT(c.strRoomType) * d.dblRoomRate) as amount'))
                ->where([['a.strResRReservationID', '=', $ReservationID], ['d.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = d.strRoomTypeID)")]])
                ->groupBy('c.strRoomType', 'd.dblRoomRate')
                ->get();

            foreach ($rooms as $room) {
                $room->strRoomType = $room->strRoomType . " Room";
                $room->amount *= $DaysOfExtend;
                $TableRows++;
            }

            $intTotal = $this->GetTotal($intTotal, $rooms);

            $pdf = PDF::loadview('pdf.service_invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $CustomerName, 'CustomerAddress' => $CustomerAddress, 'date' => $dateNow, 'InvoiceType' => $strInvoiceType, 'total' => $intTotal, 'payment' => $dblAmountTendered, 'TableRows' => $TableRows, 'Rooms' => $rooms, 'days' => $DaysOfExtend])->setPaper('A6', 'portrait');
            return $pdf->stream();

        }else if($strInvoiceType == 'ItemRental' || $strInvoiceType == 'ItemRentalExtend') {

            if($strInvoiceType == 'ItemRental') {

                $CustomerID = $request->input('iCustomerID');
                $strItemName = $request->input('iItemName');
                $intItemQuantity = $request->input('iItemQuantity');
                $dblItemRate = $request->input('iItemRate');
                $intItemHours = $request->input('iItemHours');

                $CustomerInfo = $this->GetCustomerInfo($CustomerID, "CustomerID");

                $RentedItemID = $this->SmartCounter("tblRentedItem", "strRentedItemID");
                $InvoiceNumber = $this->GetInvoiceNumber($strInvoiceType, $RentedItemID);

            }else if($strInvoiceType == 'ItemRentalExtend') {

                $ReservationID = $request->input('iReservationID');
                $RentedItemID = $request->input('RentedItemID');
                $strItemName = $request->input('iItemExtendName');
                $intItemQuantity = $request->input('iItemExtendQuantity');
                $dblItemRate = $request->input('iItemExtendRate');
                $intItemHours = $request->input('iItemExtendHours');

                $CustomerInfo = $this->GetCustomerInfo($ReservationID, "ReservationID");

                $InvoiceNumber = $this->GetInvoiceNumber($strInvoiceType, $RentedItemID);

            }

            $CustomerAddress = $CustomerInfo[0];
            $CustomerName = $CustomerInfo[1];

            $RentedItem = array(
                (object) array("name" => $strItemName, "price" => $dblItemRate, "quantity" => $intItemQuantity, "hours" => $intItemHours, "amount" => $dblItemRate * $intItemQuantity * $intItemHours)
            );
            $TableRows++;

            $intTotal = $this->GetTotal($intTotal, $RentedItem);

            $pdf = PDF::loadview('pdf.service_invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $CustomerName, 'CustomerAddress' => $CustomerAddress, 'date' => $dateNow, 'InvoiceType' => $strInvoiceType, 'total' => $intTotal, 'payment' => $dblAmountTendered, 'TableRows' => $TableRows, 'items' => $RentedItem])->setPaper('A6', 'portrait');
            return $pdf->stream();
            
        }else if($strInvoiceType == 'ItemRentalExcess') {

            $ReservationID = $request->input('ieReservationID');
            $RentedItemID = $request->input('eRentedItemID');
            $strItemName = $request->input('iItemNameExcess');
            $intItemQuantity = $request->input('iItemQuantityExcess');
            $dblItemPenalty = $request->input('iItemPenalty');
            $dblItemBrokenPenalty = $request->input('iItemBrokenPenalty');

            $CustomerInfo = $this->GetCustomerInfo($ReservationID, "ReservationID");

            $InvoiceNumber = $this->GetInvoiceNumber($strInvoiceType, $RentedItemID);

            $CustomerAddress = $CustomerInfo[0];
            $CustomerName = $CustomerInfo[1];

            $RentedItem = array(
                (object) array("name" => 'Overtime ' . $strItemName, "quantity" => $intItemQuantity, "penalty" => $dblItemPenalty, "amount" => $intItemQuantity * $dblItemPenalty)
            );
            $TableRows++;

            if($dblItemBrokenPenalty > 0) {

                $intItemBrokenQuantity = $request->input('iItemBrokenQuantity');

                array_push($RentedItem, (object) ["name" => 'Broken ' . $strItemName, "quantity" => $intItemBrokenQuantity, "penalty" => $dblItemBrokenPenalty, "amount" => $intItemBrokenQuantity * $dblItemBrokenPenalty]);
                $TableRows++;

            }

            $intTotal = $this->GetTotal($intTotal, $RentedItem);

            $pdf = PDF::loadview('pdf.service_invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $CustomerName, 'CustomerAddress' => $CustomerAddress, 'date' => $dateNow, 'InvoiceType' => $strInvoiceType, 'total' => $intTotal, 'payment' => $dblAmountTendered, 'TableRows' => $TableRows, 'items' => $RentedItem])->setPaper('A6', 'portrait');
            return $pdf->stream();

        }else if($strInvoiceType == 'AddRoom') {

            $ReservationID = $request->input('aReservationID');
            $tblRoomInfo = $request->input('tblRoomInfo');

            $CustomerInfo = $this->GetCustomerInfo($ReservationID, "ReservationID");

            $InvoiceNumber = $this->GetInvoiceNumber($strInvoiceType, $ReservationID);

            $CustomerAddress = $CustomerInfo[0];
            $CustomerName = $CustomerInfo[1];

            $days = DB::table('tblReservationDetail')
                ->select(DB::raw("TIMESTAMPDIFF(DAY,dtmResDArrival,dtmResDDeparture) as days"))
                ->where('strReservationID', '=', $ReservationID)
                ->first();

            $tblRoomInfo = json_decode($tblRoomInfo);

            $rooms = array();

            for ($i = 1; $i < count($tblRoomInfo); $i++) {

                array_push($rooms, (object) ['name' => $tblRoomInfo[$i][0], 'price' => $tblRoomInfo[$i][2], 'quantity' => $tblRoomInfo[$i][3], 'days' => $days->days, 'amount' => $tblRoomInfo[$i][2] * $tblRoomInfo[$i][3] * $days->days]);
                $TableRows++;

            }

            $intTotal = $this->GetTotal($intTotal, $rooms);

            $pdf = PDF::loadview('pdf.service_invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $CustomerName, 'CustomerAddress' => $CustomerAddress, 'date' => $dateNow, 'InvoiceType' => $strInvoiceType, 'total' => $intTotal, 'payment' => $dblAmountTendered, 'TableRows' => $TableRows, 'rooms' => $rooms])->setPaper('A6', 'portrait');
            return $pdf->stream();

        }else if($strInvoiceType == 'Activities') {

            $ReservationID = $request->input('ReservationID');var_dump($ReservationID);
            $strBeachActivityName = $request->input('ActivityName');
            $dblBeachActivityRate = $request->input('ActivityRate');

            $CustomerInfo = $this->GetCustomerInfo($ReservationID, "ReservationID");

            $AvailBeachActivityID = $this->SmartCounter("tblAvailBeachActivity", "strAvailBeachActivityID");
            $InvoiceNumber = $this->GetInvoiceNumber($strInvoiceType, $AvailBeachActivityID);

            $CustomerAddress = $CustomerInfo[0];
            $CustomerName = $CustomerInfo[1];

            $BeachActivity = array(
                (object) array("name" => $strBeachActivityName, "price" => $dblBeachActivityRate, "quantity" => 1, "amount" => $dblBeachActivityRate)
            );
            $TableRows++;

            $intTotal = $this->GetTotal($intTotal, $BeachActivity);

            $pdf = PDF::loadview('pdf.service_invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $CustomerName, 'CustomerAddress' => $CustomerAddress, 'date' => $dateNow, 'InvoiceType' => $strInvoiceType, 'total' => $intTotal, 'payment' => $dblAmountTendered, 'TableRows' => $TableRows, 'activity' => $BeachActivity])->setPaper('A6', 'portrait');
            return $pdf->stream();

        }else if($strInvoiceType == 'CheckIn') {

            $ReservationID = $request->input('iReservationID');
            $dblTotalAmount = $request->input('iTotalAmount');

            $CustomerInfo = $this->GetCustomerInfo($ReservationID, "ReservationID");

            $InvoiceNumber = $this->GetInvoiceNumber($strInvoiceType, $ReservationID);

            $CustomerAddress = $CustomerInfo[0];
            $CustomerName = $CustomerInfo[1];

            $bill = array(
                (object) array("name" => "Initial Bill Balance", "price" => $dblTotalAmount, "amount" => $dblTotalAmount)
            );
            $TableRows++;

            $intTotal = $this->GetTotal($intTotal, $bill);

            $pdf = PDF::loadview('pdf.service_invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $CustomerName, 'CustomerAddress' => $CustomerAddress, 'date' => $dateNow, 'InvoiceType' => $strInvoiceType, 'total' => $intTotal, 'payment' => $dblAmountTendered, 'TableRows' => $TableRows, 'bill' => $bill])->setPaper('A6', 'portrait');
            return $pdf->stream();

        }else if($strInvoiceType == 'CheckOut') {

            $ReservationID = $request->input('iReservationID');
            $tblRoomInfo = $request->input('tblRoomInfo');
            $tblItemInfo = $request->input('tblItemInfo');
            $tblActivityInfo = $request->input('tblActivityInfo');
            $tblFeeInfo = $request->input('tblFeeInfo');
            $tblMiscellaneousInfo = $request->input('tblMiscellaneousInfo');
            $tblAdditionalRooms = $request->input('tblAdditionalRooms');
            $tblUpgradeRooms = $request->input('tblUpgradeRooms');
            $tblExtendStay = $request->input('tblExtendStay');
            $tblBoatInfo = $request->input('tblBoatInfo');

            $CustomerInfo = $this->GetCustomerInfo($ReservationID, "ReservationID");

            $InvoiceNumber = $this->GetInvoiceNumber($strInvoiceType, $ReservationID);

            $CustomerAddress = $CustomerInfo[0];
            $CustomerName = $CustomerInfo[1];

            $days = DB::table('tblReservationDetail')
                ->select(DB::raw("TIMESTAMPDIFF(DAY,dtmResDArrival,dtmResDDeparture) as days"))
                ->where('strReservationID', '=', $ReservationID)
                ->first();
            $intDaysOfStay = $days->days;

            $bills = array();

            if($tblRoomInfo != '') {

                $tblRoomInfo = json_decode($tblRoomInfo);

                for ($i = 1; $i < count($tblRoomInfo); $i++) {

                    array_push($bills, (object) ['name' => $tblRoomInfo[$i][1], 'price' => $tblRoomInfo[$i][2], 'quantity' => 1, 'days' => $intDaysOfStay, 'amount' => $tblRoomInfo[$i][2] * $intDaysOfStay]);
                    $TableRows++;

                }

            }

            if($tblItemInfo != '') {

                $tblItemInfo = json_decode($tblItemInfo);

                for ($i = 1; $i < count($tblItemInfo); $i++) {

                    array_push($bills, (object) ['name' => $tblItemInfo[$i][0], 'price' => $tblItemInfo[$i][2], 'quantity' => $tblItemInfo[$i][1], 'days' => $tblItemInfo[$i][3], 'amount' => $tblItemInfo[$i][2] * $tblItemInfo[$i][1] * $tblItemInfo[$i][3]]);
                    $TableRows++;

                }

            }

            if($tblActivityInfo != '') {

                $tblActivityInfo = json_decode($tblActivityInfo);

                for ($i = 1; $i < count($tblActivityInfo); $i++) {

                    array_push($bills, (object) ['name' => $tblActivityInfo[$i][0], 'price' => $tblActivityInfo[$i][2], 'quantity' => $tblActivityInfo[$i][1], 'days' => "-", 'amount' => $tblActivityInfo[$i][2] * $tblActivityInfo[$i][1]]);
                    $TableRows++;

                }

            }

            if($tblFeeInfo != '') {

                $tblFeeInfo = json_decode($tblFeeInfo);

                for ($i = 1; $i < count($tblFeeInfo); $i++) {

                    array_push($bills, (object) ['name' => $tblFeeInfo[$i][0], 'price' => $tblFeeInfo[$i][2], 'quantity' => $tblFeeInfo[$i][1], 'days' => "-", 'amount' => $tblFeeInfo[$i][2] * $tblFeeInfo[$i][1]]);
                    $TableRows++;

                }

            }

            if($tblMiscellaneousInfo != '') {

                $tblMiscellaneousInfo = json_decode($tblMiscellaneousInfo);

                for ($i = 1; $i < count($tblMiscellaneousInfo); $i++) {

                    array_push($bills, (object) ['name' => $tblMiscellaneousInfo[$i][0], 'price' => $tblMiscellaneousInfo[$i][2], 'quantity' => $tblMiscellaneousInfo[$i][1], 'days' => "-", 'amount' => $tblMiscellaneousInfo[$i][2] * $tblMiscellaneousInfo[$i][1]]);
                    $TableRows++;

                }

            }

            if($tblAdditionalRooms != '') {

                $tblAdditionalRooms = json_decode($tblAdditionalRooms);

                for ($i = 1; $i < count($tblAdditionalRooms); $i++) {

                    array_push($bills, (object) ['name' => "Additional Room: " . $tblAdditionalRooms[$i][1], 'price' => $tblAdditionalRooms[$i][2], 'quantity' => 1, 'days' => $intDaysOfStay, 'amount' => $tblAdditionalRooms[$i][2] * 1 * $intDaysOfStay]);
                    $TableRows++;

                }

            }

            if($tblUpgradeRooms != '') {

                $tblUpgradeRooms = json_decode($tblUpgradeRooms);

                for ($i = 1; $i < count($tblUpgradeRooms); $i++) {

                    array_push($bills, (object) ['name' => "Upgrade Room: " . $tblUpgradeRooms[$i][0], 'price' => $tblUpgradeRooms[$i][1], 'quantity' => 1, 'days' => $intDaysOfStay, 'amount' => $tblUpgradeRooms[$i][1] * 1 * $intDaysOfStay]);
                    $TableRows++;

                }

            }

            if($tblExtendStay != '') {

                $tblExtendStay = json_decode($tblExtendStay);

                for ($i = 1; $i < count($tblExtendStay); $i++) {

                    array_push($bills, (object) ['name' => "Extend Stay", 'price' => $tblExtendStay[$i][1], 'quantity' => '-', 'days' => $tblExtendStay[$i][0], 'amount' => $tblExtendStay[$i][1] * $tblExtendStay[$i][0]]);
                    $TableRows++;

                }

            }

            if($tblBoatInfo != '') {

                $tblBoatInfo = json_decode($tblBoatInfo);

                for ($i = 1; $i < count($tblBoatInfo); $i++) {

                    array_push($bills, (object) ['name' => "Boat Rental: " . $tblBoatInfo[$i][0], 'price' => $tblBoatInfo[$i][1], 'quantity' => 1, 'days' => "-", 'amount' => $tblBoatInfo[$i][1]]);
                    $TableRows++;

                }

            }

            $intTotal = $this->GetTotal($intTotal, $bills);

            $pdf = PDF::loadview('pdf.invoice', ['InvoiceNumber' => $InvoiceNumber, 'CustomerName' => $CustomerName, 'CustomerAddress' => $CustomerAddress, 'date' => $dateNow, 'InvoiceType' => $strInvoiceType, 'total' => $intTotal, 'payment' => $dblAmountTendered, 'TableRows' => $TableRows, 'days' => $intDaysOfStay, 'bill' => $bills]);
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

        }else if($InvoiceType == 'WalkIn' || $InvoiceType == 'WalkInPackage') {

            $InvoiceNumber .= "23" . $ID;

            return $InvoiceNumber;

        }else if($InvoiceType == 'BoatRental') {

            $InvoiceNumber .= "219" . $ID;

            return $InvoiceNumber;

        }else if($InvoiceType == 'UpgradeRoom') {

            $InvoiceNumber .= "16" . $ID;

            return $InvoiceNumber;

        }else if($InvoiceType == 'Fees') {

            $InvoiceNumber .= "6" . $ID;

            return $InvoiceNumber;

        }else if($InvoiceType == 'ExtendStay') {

            $InvoiceNumber .= "519" . $ID;

            return $InvoiceNumber;

        }else if($InvoiceType == 'ItemRental') {

            $InvoiceNumber .= "91" . $ID;

            return $InvoiceNumber;

        }else if($InvoiceType == 'ItemRentalExtend') {

            $InvoiceNumber .= "92" . $ID;

            return $InvoiceNumber;

        }else if($InvoiceType == 'ItemRentalExcess') {

            $InvoiceNumber .= "93" . $ID;

            return $InvoiceNumber;

        }else if($InvoiceType == 'Activities') {

            $InvoiceNumber .= "1" . $ID;

            return $InvoiceNumber;

        }else if($InvoiceType == 'CheckIn') {

            $InvoiceNumber .= "39" . $ID;

            return $InvoiceNumber;

        }else if($InvoiceType == 'CheckOut') {

            $InvoiceNumber .= "315" . $ID;

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
