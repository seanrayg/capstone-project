<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class ViewResortController extends Controller
{
    
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
    
    /*------------ROOMS--------------*/
    //
    public function ViewSelectedRooms($id){
        $ChosenRooms = $this->getReservedRooms($id);
        
        return view('ChooseRooms', compact('ChosenRooms'));
    }
    
    public function getReservedRooms($ReservationID){
        $ChosenRooms = DB::table('tblReservationRoom as a')
                            ->join ('tblRoom as b', 'a.strResRRoomID', '=' , 'b.strRoomID')
                            ->join ('tblRoomType as c', 'c.strRoomTypeID', '=' , 'b.strRoomTypeID')
                            ->join ('tblRoomRate as d', 'c.strRoomTypeID', '=' , 'd.strRoomTypeID')
                            ->select('c.strRoomTypeID',
                                     'c.strRoomType',
                                     'c.intRoomTCapacity',
                                      DB::raw('COUNT(c.strRoomTypeID) as TotalRooms'),
                                     'd.dblRoomRate')
                            ->where([['strResRReservationID', '=', $ReservationID], ['d.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = c.strRoomTypeID)")]])
                            ->groupBy('c.strRoomTypeID', 'c.strRoomType', 'c.intRoomTCapacity', 'd.dblRoomRate')
                            ->get();
        
        return $ChosenRooms;
    }
    
    
    //GET ROOMS AJAX
    public function getChosenRooms(Request $req){
        $RoomTypeName = trim($req->input('ChosenRoomType'));
        $ReservationID = trim($req->input('ReservationID'));
        
        $RoomTypeID = DB::table('tblRoomType')->where([['intRoomTDeleted', '1'],['strRoomType', $RoomTypeName]])->orderBy('strRoomTypeID')->pluck('strRoomTypeID');
        
        $ReservedRooms = DB::table('tblReservationRoom as a')
                            ->join ('tblRoom as b', 'a.strResRRoomID', '=' , 'b.strRoomID')
                            ->select('b.strRoomName')
                            ->where([['strResRReservationID', '=', $ReservationID], ['b.strRoomTypeID', $RoomTypeID]])
                            ->get();
        
        return response()->json($ReservedRooms);
    }
    
    //GET AVAILABLE ROOMS AJAX
    
    public function getAvailableRooms(Request $req){
        $RoomTypeName = trim($req->input('ChosenRoomType'));
        $ReservationID = trim($req->input('ReservationID'));
        
        $tempRoomTypeID = DB::table('tblRoomType')->select('strRoomTypeID')->where([['intRoomTDeleted', '1'],['strRoomType', $RoomTypeName]])->get();
        $RoomTypeID = "";
        $ReservationDates = DB::table('tblReservationDetail')
                            ->select('dtmResDArrival',
                                     'dtmResDDeparture')
                            ->where('strReservationID', $ReservationID)
                            ->get();
        
        $ArrivalDate = "";
        $DepartureDate = "";
        
        foreach($ReservationDates as $Dates){
            $ArrivalDate = $Dates->dtmResDArrival;
            $DepartureDate = $Dates->dtmResDDeparture;
        }
        
        foreach($tempRoomTypeID as $tempID){
            $RoomTypeID = $tempID->strRoomTypeID;
        }
        
        $CheckInDate = str_replace("-","/",$ArrivalDate);
        $CheckOutDate = str_replace("-","/",$DepartureDate);
        
        $ExistingReservations = DB::table('tblReservationDetail')
                                ->where(function($query){
                                    $query->where('intResDStatus', '=', '1')
                                          ->orWhere('intResDStatus', '=', '2')
                                          ->orWhere('intResDStatus', '=', '4');
                                })
                                ->where(function($query) use($CheckInDate, $CheckOutDate){
                                    $query->whereBetween('dtmResDArrival', [$CheckInDate, $CheckOutDate])
                                          ->orWhereBetween('dtmResDDeparture', [$CheckInDate, $CheckOutDate]);
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
                    ->select('a.strRoomTypeID',
                             'a.strRoomName')
                     ->whereNotIn('strRoomID', $ExistingRooms)
                     ->where([['a.strRoomStatus','=','Available'],['a.strRoomTypeID', '=', $RoomTypeID]])
                     ->get();

        return response()->json($Rooms);
    }
    
    
    //ROOM NAV BAR
    
    public function ViewRooms(){
        $RoomDetails = DB::table('tblReservationRoom as a')
                            ->join ('tblRoom as b', 'a.strResRRoomID', '=' , 'b.strRoomID')
                            ->join ('tblRoomType as c', 'c.strRoomTypeID', '=' , 'b.strRoomTypeID')
                            ->join ('tblReservationDetail as d', 'a.strResRReservationID', '=' , 'd.strReservationID')
                            ->join ('tblCustomer as e', 'e.strCustomerID', '=' , 'd.strResDCustomerID')
                            ->select('d.strReservationID',
                                     'c.strRoomType',
                                     'b.strRoomName',
                                     DB::raw('CONCAT(e.strCustFirstName , " " , e.strCustLastName) AS Name'),
                                     'e.strCustContact',
                                     'd.dtmResDArrival',
                                     'd.dtmResDDeparture')
                            ->where('intResDStatus', 4)
                            ->get();
        
        
        return view('Rooms', compact('RoomDetails'));
    }
    
    
    /*---------------- CUSTOMERS ---------------*/
    
    //CUSTOMER NAV BAR
    public function ViewCustomers(){
        $CustomerDetails = DB::table('tblCustomer')
                            ->where('intCustStatus', 1)
                            ->get();
        
        foreach($CustomerDetails as $Customer){
            if($Customer->strCustGender == "M"){
                $Customer->strCustGender = "Male";
            }
            else{
                $Customer->strCustGender = "Female";
            }
        }
        
        return view('Customers', compact('CustomerDetails'));
    }
    
    
    
    
    /*------------------ WALK IN -----------------*/
    
    public function ViewWalkIn(){
        $Fees = DB::table('tblFee as a')
                ->join ('tblFeeAmount as b', 'a.strFeeID', '=' , 'b.strFeeID')
                ->select('a.strFeeName')
                ->where([['b.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")],['a.strFeeStatus', '=', 'Active']])
                ->get();
        
        return view ('Walkin', compact('Fees'));
    }
    
    //Get Fees AJAX
    public function getFeeAmount(Request $req){
        $FeeName = trim($req->input('SelectedFee'));
        $FeeAmount = DB::table('tblFee as a')
                ->join ('tblFeeAmount as b', 'a.strFeeID', '=' , 'b.strFeeID')
                ->select('b.dblFeeAmount')
                ->where([['b.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")],['a.strFeeName', '=', $FeeName], ['a.strFeeStatus', '=', 'Active']])
                ->get();
        
        return response()->json($FeeAmount);
    }
    
    
    
    /*------------------ ITEM RENTAL -----------*/
    
    function getAvailableItems(){
        $RentalItems = DB::table('tblItem as a')
                ->join ('tblItemRate as b', 'a.strItemID', '=' , 'b.strItemID')
                ->select('a.strItemID',
                         'a.strItemName',
                         'a.intItemQuantity',
                         'b.dblItemRate',
                         'a.strItemDescription')
                ->where([['b.dtmItemRateAsOf',"=", DB::raw("(SELECT max(dtmItemRateAsOf) FROM tblItemRate WHERE strItemID = a.strItemID)")],
                        ['a.intItemDeleted',"=", "1"], ['a.intItemQuantity', "!=", 0]])
                ->get();
        
        $RentedItems = DB::table('tblRentedItem as a')
                ->join ('tblItem as b', 'b.strItemID', '=' , 'a.strRentedIItemID')
                ->join ('tblReservationDetail as c', 'c.strReservationID', '=' , 'a.strRentedIReservationID')
                ->join ('tblCustomer as d', 'c.strResDCustomerID', '=' , 'd.strCustomerID')
                ->join ('tblItemRate as e', 'e.strItemID', '=' , 'b.strItemID')
                ->select(DB::raw('CONCAT(d.strCustFirstName , " " , d.strCustLastName) AS Name'),
                        'b.strItemID',
                        'b.strItemName',
                        'a.tmsCreated',
                        'a.intRentedIDuration',
                        'a.intRentedIQuantity',
                        DB::raw('a.intRentedIBroken AS ExcessTime'),
                        DB::raw('b.strItemDescription AS RentalStatus'),
                        'e.dblItemRate',
                        'c.strReservationID',
                        'b.strItemID',
                        'a.strRentedItemID')
                ->where([['a.intRentedIReturned', '=', 0], ['e.dtmItemRateAsOf',"=", DB::raw("(SELECT max(dtmItemRateAsOf) FROM tblItemRate WHERE strItemID = b.strItemID)")]])
                ->get();
        
        $DateTimeToday = Carbon::now('HongKong');
        foreach($RentedItems as $Items){
            $Items->tmsCreated = Carbon::parse($Items->tmsCreated)->format('M j, Y g:i A');
            $Items->intRentedIDuration = Carbon::parse($Items->tmsCreated)->addHours($Items->intRentedIDuration)->format('M j, Y g:i A');
            
            $tempHour = Carbon::parse($Items->intRentedIDuration);
            
            $start_time = $tempHour->toDateTimeString();
            $end_time = $DateTimeToday->toDateTimeString();
            
            $time1 = new DateTime($start_time);
            $time2 = new DateTime($end_time);
            $interval = $time1->diff($time2);
          
            $hour = $interval->format('%h');
            $min = $interval->format('%i');
            
            if($end_time > $start_time){
                $Items->ExcessTime = $hour ." hour(s) ". $min ." minutes";
                $Items->RentalStatus = "Overtime";
            }
            else{
                $Items->ExcessTime = "None";
                $Items->RentalStatus = "Undertime";
            }

        }
        
        foreach($RentalItems as $Rental){
            foreach($RentedItems as $Rented){
                if($Rental->strItemID == $Rented->strItemID){
                    $Rental->intItemQuantity -= (int)$Rented->intRentedIQuantity;
                }
            }
        }
        
        $BrokenItems = DB::table('tblRentedItem as a')
                ->join ('tblItem as b', 'b.strItemID', '=' , 'a.strRentedIItemID')
                ->join ('tblReservationDetail as c', 'c.strReservationID', '=' , 'a.strRentedIReservationID')
                ->join ('tblCustomer as d', 'c.strResDCustomerID', '=' , 'd.strCustomerID')
                ->select(DB::raw('CONCAT(d.strCustFirstName , " " , d.strCustLastName) AS Name'),
                        'b.strItemID',
                        'b.strItemName',
                        'a.intRentedIBrokenQuantity',
                        'c.strReservationID',
                        'b.strItemID',
                        'a.strRentedItemID',
                        'a.tmsCreated')
                ->where([['a.intRentedIBroken', '=', 1], ['a.intRentedIBrokenQuantity', '!=', '0']])
                ->get();
        
        foreach($RentalItems as $Rental){
            foreach($BrokenItems as $Broken){
                if($Rental->strItemID == $Broken->strItemID){
                    $Rental->intItemQuantity -= (int)$Broken->intRentedIBrokenQuantity;
                }
            }
        }
        //dd($RentalItems);

        $Guests = DB::table('tblReservationDetail as a')
                        ->join ('tblCustomer as b', 'a.strResDCustomerID', '=' , 'b.strCustomerID')
                        ->select(DB::raw('CONCAT(b.strCustFirstName , " " , b.strCustLastName) AS Name'))
                        ->where('a.intResDStatus', '=', '4')
                        ->orderBy('Name')
                        ->get();
        
        return view('ItemRental', compact('RentalItems', 'Guests', 'RentedItems', 'BrokenItems'));
    }
    
    /*------ Boat Schedule ------*/

    function getAvailableBoats(){
        $AvailableBoats = DB::table('tblBoat as a')
        ->join ('tblBoatRate as b', 'a.strBoatID', '=' , 'b.strBoatID')
        ->select('a.strBoatID', 
                 'a.strBoatName',
                 'a.intBoatCapacity',
                 'b.dblBoatRate',
                 'a.strBoatDescription')
        ->where('b.dtmBoatRateAsOf',"=", DB::raw("(SELECT max(dtmBoatRateAsOf) FROM tblBoatRate WHERE strBoatID = a.strBoatID)"))
        ->where(function($query){
            $query->where('a.strBoatStatus', '=', 'Available');
        })
        ->get();

        $ActiveCustomers = DB::table('tblCustomer as a')
        ->join('tblReservationDetail as b', 'a.strCustomerID', '=', 'b.strResDCustomerID')
        ->select('a.strCustomerID', 'a.strCustFirstName', 'a.strCustLastName')
        ->where('b.intResDStatus', '=', 2)
        ->get();

        return view('BoatSchedule', compact('AvailableBoats', 'ActiveCustomers'));

    }
    
}
