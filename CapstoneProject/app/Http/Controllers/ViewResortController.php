<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
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
        
        $Rooms = DB::select("SELECT a.strRoomTypeID, a.strRoomName FROM tblRoom a, tblRoomType b WHERE strRoomID NOT IN(SELECT strResRRoomID FROM tblReservationRoom WHERE strResRReservationID IN(SELECT strReservationID FROM tblReservationDetail WHERE (intResDStatus = 1 OR intResDStatus = 2 OR intResDStatus = 4) AND ((dtmResDDeparture BETWEEN '".$CheckInDate."' AND '".$CheckOutDate."') OR (dtmResDArrival BETWEEN '".$CheckInDate."' AND '".$CheckOutDate."') AND NOT intResDStatus = 3))) AND a.strRoomTypeID = '".$RoomTypeID."' AND a.strRoomTypeID = b.strRoomTypeID AND a.strRoomStatus = 'Available'");

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
                ->select(DB::raw('CONCAT(d.strCustFirstName , " " , d.strCustLastName) AS Name'),
                        'b.strItemID',
                        'b.strItemName',
                        'a.tmsCreated',
                        'a.intRentedIDuration',
                        'a.intRentedIQuantity')
                ->where('a.intRentedIReturned', '=', 0)
                ->get();
        
        foreach($RentedItems as $Items){
            $Items->tmsCreated = Carbon::parse($Items->tmsCreated)->format('g:i A');
            $Items->intRentedIDuration = Carbon::parse($Items->tmsCreated)->addHours($Items->intRentedIDuration)->format('g:i A');
        }
        
        foreach($RentalItems as $Rental){
            foreach($RentedItems as $Rented){
                if($Rental->strItemID == $Rented->strItemID){
                    $Rental->intItemQuantity -= (int)$Rented->intRentedIQuantity;
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
        
        return view('ItemRental', compact('RentalItems', 'Guests', 'RentedItems'));
    }
    
    
}
