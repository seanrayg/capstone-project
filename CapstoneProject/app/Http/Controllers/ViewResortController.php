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
    
    public function ViewUpgradeRoom($id, $RoomType, $RoomName){
        $ReservationID = $id;
        
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

        
        $CheckInDate = Carbon::now('Asia/Manila')->format('Y/m/d h:i:s');
    
        $CheckOutDate = str_replace("-","/",$DepartureDate);
        
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
                                ->where('strResRReservationID', '!=', $ReservationID)
                                ->pluck('strResRRoomID')
                                ->toArray();

        $tempArrivalDate = explode(" ", $ArrivalDate);
        $tempDepartureDate = explode(" ", $DepartureDate);
        
        $RoomRate = DB::table('tblRoomType as a')
            ->join ('tblRoomRate as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
            ->where([['b.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],
                    ['a.intRoomTDeleted',"=", "1"]
                    ,['a.strRoomType',"=", $RoomType]])
            ->pluck('b.dblRoomRate')
            ->first();
        
        if($tempArrivalDate[0] != $tempDepartureDate[0]){
            $Rooms = DB::table('tblRoom as a')
                        ->join ('tblRoomType as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
                        ->join ('tblRoomRate as c', 'a.strRoomTypeID', '=' , 'c.strRoomTypeID')
                        ->select('b.strRoomType',
                                 'b.strRoomTypeID',
                                 DB::raw("COUNT(a.strRoomTypeID) as TotalRooms"))
                         ->whereNotIn('strRoomID', $ExistingRooms)
                         ->where([['a.strRoomStatus','=','Available'],['b.intRoomTCategory', '=', 1],['b.strRoomType', "!=", $RoomType], ['c.dblRoomRate', ">=", $RoomRate]])
                         ->groupBy('b.strRoomType', 'b.strRoomTypeID')
                         ->get();
        }
        else{
            $Rooms = DB::table('tblRoom as a')
                        ->join ('tblRoomType as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
                        ->join ('tblRoomRate as c', 'a.strRoomTypeID', '=' , 'c.strRoomTypeID')
                        ->select('b.strRoomType',
                                 'b.strRoomTypeID', 
                                DB::raw("COUNT(a.strRoomTypeID) as TotalRooms"))
                         ->whereNotIn('strRoomID', $ExistingRooms)
                         ->where([['a.strRoomStatus','=','Available'],['b.strRoomType', "!=", $RoomType], ['c.dblRoomRate', ">=", $RoomRate]])
                         ->groupBy('b.strRoomType', 'b.strRoomTypeID')
                         ->get();
        }
        
        foreach($Rooms as $Room){
            if($Room->TotalRooms == 0){
                $Rooms->forget($Room->strRoomType);
            }
        }
        
        
        
        return view('UpgradeRoom', compact('Rooms'));
    }
    
    //Upgrade Room AJAX
    public function getAvailableUpgradeRooms(Request $req){
 
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
        
        $CheckInDate = Carbon::now('Asia/Manila')->format('Y/m/d h:i:s');
        $CheckOutDate = str_replace("-","/",$DepartureDate);
        
        $Rooms = $this->fnGetAvailableRooms($RoomTypeID, $CheckInDate, $CheckOutDate);

        return response()->json($Rooms);
    
    }
    
    public function fnGetAvailableRooms($RoomTypeID, $CheckInDate, $CheckOutDate){
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
                    ->select('a.strRoomTypeID',
                             'a.strRoomName')
                     ->whereNotIn('strRoomID', $ExistingRooms)
                     ->where([['a.strRoomStatus','=','Available'],['a.strRoomTypeID', '=', $RoomTypeID]])
                     ->get();
        
        return $Rooms;
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
        
        $Rooms = $this->fnGetAvailableRooms($RoomTypeID, $CheckInDate, $CheckOutDate);

        return response()->json($Rooms);
    }
    
    public function getRoomPrice(Request $req){
        $ReservationID = trim($req->input('ReservationID'));
        $OriginalRoom = trim($req->input('OriginalRoom'));
        $UpgradeRoom = trim($req->input('UpgradeRoom'));
        
        $OriginalRoomPrice = DB::table('tblRoomType as a')
            ->join ('tblRoomRate as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
            ->select('b.dblRoomRate')
            ->where([['b.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],
                    ['a.intRoomTDeleted',"=", "1"]
                    ,['a.strRoomType', '=', $OriginalRoom]])
            ->get();
        
        $UpgradeRoomPrice = DB::table('tblRoomType as a')
            ->join ('tblRoomRate as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
            ->select('b.dblRoomRate')
            ->where([['b.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],
                    ['a.intRoomTDeleted',"=", "1"]
                    ,['a.strRoomType', '=', $UpgradeRoom]])
            ->get();
        
        $ReservationDates = DB::table('tblReservationDetail')
                            ->select('dtmResDArrival',
                                     'dtmResDDeparture')
                            ->where('strReservationID', $ReservationID)
                            ->get();
        
        return response()->json(['OriginalRoomPrice' => $OriginalRoomPrice, 'UpgradeRoomPrice' => $UpgradeRoomPrice, 'ReservationDates' => $ReservationDates]);
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
        
        $DateTimeToday = Carbon::now('Asia/Manila')->toDateTimeString();
        $DateTimeNextWeek = Carbon::now('Asia/Manila')->addDays(7)->toDateTimeString();
        $DateTimeFiveDays = Carbon::now('Asia/Manila')->addDays(5)->toDateTimeString();
        $DateTimeThreeDays = Carbon::now('Asia/Manila')->addDays(3)->toDateTimeString();
        $DateTimeTomorrow = Carbon::now('Asia/Manila')->addDays(1)->toDateTimeString();
        
        $DateTimeToday = str_replace("-","/",$DateTimeToday);
        $DateTimeNextWeek = str_replace("-","/",$DateTimeNextWeek);
        $DateTimeFiveDays = str_replace("-","/",$DateTimeFiveDays);
        $DateTimeThreeDays = str_replace("-","/",$DateTimeThreeDays);
        $DateTimeTomorrow = str_replace("-","/",$DateTimeTomorrow);

 
        $RoomsNextWeek = $this->fnGetAvailableRoomsByDate($DateTimeToday, $DateTimeNextWeek);
        $RoomsFiveDays = $this->fnGetAvailableRoomsByDate($DateTimeToday, $DateTimeFiveDays);
        $RoomsThreeDays = $this->fnGetAvailableRoomsByDate($DateTimeToday, $DateTimeThreeDays);
        $RoomsTomorrow = $this->fnGetAvailableRoomsByDate($DateTimeToday, $DateTimeTomorrow);
        

        foreach($RoomsNextWeek as $NextWeek){
            $NextWeek->Availability = "Available for the next 7 days";
        }
        
        
        foreach($RoomsFiveDays as $FiveDays){
            $FiveDays->Availability = "Available for the next 5 days";
        }
     
        foreach($RoomsThreeDays as $ThreeDays){
            $ThreeDays->Availability = "Available for the next 3 days";
        }
        
        foreach($RoomsTomorrow as $Tomorrow){
            $Tomorrow->Availability = "Available until tomorrow";
        }
        
        $tempMerge = $RoomsNextWeek->merge($RoomsFiveDays);
        $tempMerge2 = $RoomsThreeDays->merge($RoomsTomorrow);
        
        $tempRoomsAvailable = $tempMerge->merge($tempMerge2);
        
        $RoomsAvailable = $tempRoomsAvailable->unique('strRoomName');
        
        foreach($RoomsAvailable as $Rooms){
            if($Rooms->intRoomTCategory == 1){
                $Rooms->intRoomTCategory = "Room";
            }
            else{
                $Rooms->intRoomTCategory = "Cottage";
            }
        }
        
      
        return view('Rooms', compact('RoomDetails', 'RoomsAvailable'));
    }
    
    
    public function fnGetAvailableRoomsByDate($ArrivalDate, $DepartureDate){
        $ExistingReservations = DB::table('tblReservationDetail')
                                ->where(function($query){
                                    $query->where('intResDStatus', '=', '1')
                                          ->orWhere('intResDStatus', '=', '2')
                                          ->orWhere('intResDStatus', '=', '4');
                                })
                                ->where(function($query) use($ArrivalDate, $DepartureDate){
                                    $query->where('dtmResDArrival','>=',$ArrivalDate)
                                          ->where('dtmResDArrival','<=',$DepartureDate);
                                })
                                ->orWhere(function($query) use($ArrivalDate, $DepartureDate){
                                    $query->where('dtmResDDeparture','>=',$ArrivalDate)
                                          ->where('dtmResDDeparture','<=',$DepartureDate);
                                })
                                ->where(function($query) use($ArrivalDate, $DepartureDate){
                                    $query->where('dtmResDArrival','<=',$ArrivalDate)
                                          ->where('dtmResDDeparture','>=',$ArrivalDate);
                                })
                                ->orWhere(function($query) use($ArrivalDate, $DepartureDate){
                                    $query->where('dtmResDArrival','<=',$DepartureDate)
                                          ->where('dtmResDDeparture','>=',$DepartureDate);
                                })
                                ->pluck('strReservationID')
                                ->toArray();
    
        $ExistingRooms = DB::table('tblReservationRoom')
                                ->whereIn('strResRReservationID', $ExistingReservations)
                                ->pluck('strResRRoomID')
                                ->toArray();
        
        $Rooms = DB::table('tblRoom as a')
                    ->join ('tblRoomType as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
                    ->join ('tblRoomRate as c', 'a.strRoomTypeID', '=' , 'c.strRoomTypeID')
                    ->select('b.strRoomType',
                             'a.strRoomName',
                             'c.dblRoomRate', 
                             'b.intRoomTCapacity',
                             DB::raw("b.intRoomTAirconditioned as Availability"),
                             'b.intRoomTCategory')
                     ->whereNotIn('strRoomID', $ExistingRooms)
                     ->where([['a.strRoomStatus','=','Available'],['c.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")]])
                     ->get();
        
        return $Rooms;
        
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
        
        $CustomerResort = DB::table('tblCustomer as a')
                            ->join ('tblReservationDetail as b', 'b.strResDCustomerID', '=' , 'a.strCustomerID')
                            ->where([['a.intCustStatus', 1],['b.intResDStatus', '=', '4']])
                            ->get();
        
        return view('Customers', compact('CustomerDetails', 'CustomerResort'));
    }
    
    //get available rooms for add rooms
    public function getAddAvailableRooms(Request $req){
        $ArrivalDate = trim($req->input('ArrivalDate'));
        $DepartureDate = trim($req->input('DepartureDate'));
        
        $DepartureDate = Carbon::parse($DepartureDate)->format('Y/m/d h:i:s');
        
        $ExistingReservations = DB::table('tblReservationDetail')
                                ->where(function($query){
                                    $query->where('intResDStatus', '=', '1')
                                          ->orWhere('intResDStatus', '=', '2')
                                          ->orWhere('intResDStatus', '=', '4');
                                })
                                ->where(function($query) use($ArrivalDate, $DepartureDate){
                                    $query->where('dtmResDArrival','>=',$ArrivalDate)
                                          ->where('dtmResDArrival','<=',$DepartureDate);
                                })
                                ->orWhere(function($query) use($ArrivalDate, $DepartureDate){
                                    $query->where('dtmResDDeparture','>=',$ArrivalDate)
                                          ->where('dtmResDDeparture','<=',$DepartureDate);
                                })
                                ->where(function($query) use($ArrivalDate, $DepartureDate){
                                    $query->where('dtmResDArrival','<=',$ArrivalDate)
                                          ->where('dtmResDDeparture','>=',$ArrivalDate);
                                })
                                ->orWhere(function($query) use($ArrivalDate, $DepartureDate){
                                    $query->where('dtmResDArrival','<=',$DepartureDate)
                                          ->where('dtmResDDeparture','>=',$DepartureDate);
                                })
                                ->pluck('strReservationID')
                                ->toArray();
        
        $ExistingRooms = DB::table('tblReservationRoom')
                                ->whereIn('strResRReservationID', $ExistingReservations)
                                ->pluck('strResRRoomID')
                                ->toArray();
        
        $tempArrivalDate = explode(" ", $ArrivalDate);
        $tempDepartureDate = explode(" ", $DepartureDate);
        
        if($tempArrivalDate[0] != $tempDepartureDate[0]){
            $Rooms = DB::table('tblRoom as a')
                        ->join ('tblRoomType as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
                        ->join ('tblRoomRate as c', 'a.strRoomTypeID', '=' , 'c.strRoomTypeID')
                        ->select('b.strRoomType', 
                         'c.dblRoomRate', 
                         'b.intRoomTCapacity', 
                         DB::raw("COUNT(a.strRoomTypeID) as TotalRooms"))
                         ->whereNotIn('strRoomID', $ExistingRooms)
                         ->where([['a.strRoomStatus','=','Available'],['c.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],['b.intRoomTCategory', '=', 1]])
                         ->groupBy('b.strRoomType','c.dblRoomRate', 'b.intRoomTCapacity')
                         ->get();
        }
        else{
            $Rooms = DB::table('tblRoom as a')
                        ->join ('tblRoomType as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
                        ->join ('tblRoomRate as c', 'a.strRoomTypeID', '=' , 'c.strRoomTypeID')
                        ->select('b.strRoomType', 
                         'c.dblRoomRate', 
                         'b.intRoomTCapacity', 
                         DB::raw("COUNT(a.strRoomTypeID) as TotalRooms"))
                         ->whereNotIn('strRoomID', $ExistingRooms)
                         ->where([['a.strRoomStatus','=','Available'],['c.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")]])
                         ->groupBy('b.strRoomType','c.dblRoomRate', 'b.intRoomTCapacity')
                         ->get();
        }
        return response()->json($Rooms);
    }
    
    
    public function checkExtendStay(Request $req){
        $ReservationID = trim($req->input('ExtendReservationID'));
        $DaysToExtend = trim($req->input('ExtendNight'));
        
        $tempArrivalDate = DB::table('tblreservationdetail')->where('strReservationID', '=', $ReservationID)->pluck('dtmResDArrival')->first();
        $tempDepartureDate = DB::table('tblreservationdetail')->where('strReservationID', '=', $ReservationID)->pluck('dtmResDDeparture')->first();
        
        $ArrivalDate = Carbon::parse($tempArrivalDate)->toDateTimeString();
        $DepartureDate = Carbon::parse($tempDepartureDate)->addDays($DaysToExtend)->toDateTimeString();
        
        $ArrivalDate = str_replace("-", "/", $ArrivalDate);
        $DepartureDate = str_replace("-","/",$DepartureDate);
   
        $AvailableRooms = $this->fnGetAvailableRoomsByReservation($ReservationID, $ArrivalDate, $DepartureDate);
        
        $ReservedRooms = DB::table('tblReservationRoom as a')
                         ->join('tblRoom as b', 'a.strResRRoomID', '=', 'b.strRoomID')
                         ->join('tblRoomType as c', 'b.strRoomTypeID', '=', 'c.strRoomTypeID')
                         ->join('tblRoomRate as d', 'd.strRoomTypeID', '=', 'c.strRoomTypeID')
                         ->select('a.strResRRoomID',
                                  'b.strRoomName',
                                  'd.dblRoomRate')
                         ->where([['strResRReservationID', '=', $ReservationID],['d.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = c.strRoomTypeID)")]])
                         ->get();
            
        $UnavailableRooms = []; 
        foreach($ReservedRooms as $Reserved){
            $found = false;
            foreach($AvailableRooms as $Available){
                if($Reserved->strResRRoomID == $Available->strRoomID){
                    $found = true;
                    break;
                }
            }
            if(!($found)){
                $UnavailableRooms[sizeof($UnavailableRooms)] = $Reserved->strRoomName;
            }
        }
        
        if(sizeof($UnavailableRooms) != 0){
            return response()->json(['UnavailableRooms' => $UnavailableRooms]);
        }
        else{
            return response()->json(['ReservedRooms' => $ReservedRooms]);
        }
    }
    
    public function fnGetAvailableRoomsByReservation($ReservationID, $CheckInDate, $CheckOutDate){
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
        
        for($x = 0; $x < sizeof($ExistingReservations); $x++){
            if($ExistingReservations[$x] == $ReservationID){
                unset($ExistingReservations[$x]);
            }
        }
        $ExistingReservations = array_values($ExistingReservations);
   
        
        $ExistingRooms = DB::table('tblReservationRoom')
                                ->whereIn('strResRReservationID', $ExistingReservations)
                                ->pluck('strResRRoomID')
                                ->toArray();

        $tempArrivalDate = explode(" ", $CheckInDate);
        $tempDepartureDate = explode(" ", $CheckOutDate);

        $Rooms = DB::table('tblRoom as a')
                    ->join ('tblRoomType as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
                    ->select('a.strRoomTypeID',
                             'a.strRoomName',
                             'a.strRoomID')
                     ->whereNotIn('strRoomID', $ExistingRooms)
                     ->where('a.strRoomStatus','=','Available')
                     ->get();
        
        return $Rooms;
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
    
    public function ViewWalkInPackage(){
        $CheckInDate = Carbon::now()->toDateTimeString();
        $CheckInDate = str_replace('-','/',$CheckInDate);

        $Packages = $this->getPackages();

        foreach($Packages as $Package){
            
            $CheckOutDate = carbon::parse($CheckInDate)->addDays($Package->intPackageDuration)->toDateTimeString();
            $CheckOutDate = str_replace('-','/', $CheckOutDate);
            
            $Rooms = $this->fnGetAvailableRoomsByPackage($CheckInDate, $CheckOutDate);
            $RoomPackage = $this->getRoomInclusion($Package->strPackageID);
        
            
            
            foreach($RoomPackage as $RPackage){
                $found = false;
                foreach($Rooms as $Room){
                    if($RPackage->strRoomType == $Room->strRoomType){
                        $found = true;
                        if($RPackage->intPackageRQuantity > $Room->TotalRooms){
                            $Package->strPackageName = "";
                        }
                    }
                }
                if(!($found)){
                    $Package->strPackageName = "";
                }
            }
        }
        
        $newPackage = $Packages->where('strPackageName', '!=', "");
        $newPackage = $newPackage->values();
      
        return view('WalkinPackage', compact('newPackage'));
    }
    
    public function getRoomInclusion($PackageID){
        $PackageRoomInfo = DB::table('tblRoomType as a')
                        ->join('tblPackageRoom as b', 'a.strRoomTypeID', '=', 'b.strPackageRRoomTypeID')
                        ->join('tblRoomRate as c', 'a.strRoomTypeID', '=', 'c.strRoomTypeID')
                        ->select('a.strRoomType',
                                 'b.intPackageRQuantity',
                                 DB::raw('(c.dblRoomRate * b.intPackageRQuantity) as RoomProduct'))
                        ->where([['b.strPackageRPackageID', '=', $PackageID], ['c.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")]])
                        ->get();
        
        return $PackageRoomInfo;
    }
    
    public function getPackages(){
       $Packages = DB::table('tblPackage as a')
                    ->join ('tblPackagePrice as b', 'a.strPackageID', '=' , 'b.strPackageID')
                    ->select('a.strPackageID',
                             'a.strPackageName',
                             'a.strPackageStatus',
                             'a.intPackageDuration',
                             'b.dblPackagePrice',
                             'a.intPackagePax',
                             'a.strPackageDescription',
                             'a.intBoatFee')
                    ->where('b.dtmPackagePriceAsOf',"=", DB::raw("(SELECT MAX(dtmPackagePriceAsOf) FROM tblPackagePrice WHERE strPackageID = a.strPackageID)"))
                    ->where(function($query){
                        $query->where('a.strPackageStatus', '=', 'Available')
                              ->orWhere('a.strPackageStatus', '=', "Unavailable");
                    })
                    ->get();
        
        foreach($Packages as $Package){
            if($Package->intBoatFee == "1"){
                $Package->intBoatFee = "Free";
            }
            else{
                $Package->intBoatFee = "Not Free";
            }
        }
        return $Packages;
    }
    
    public function fnGetAvailableRoomsByPackage($ArrivalDate, $DepartureDate){
           
        $ExistingReservations = DB::table('tblReservationDetail')
                                ->where(function($query){
                                    $query->where('intResDStatus', '=', '1')
                                          ->orWhere('intResDStatus', '=', '2')
                                          ->orWhere('intResDStatus', '=', '4');
                                })
                                ->where(function($query) use($ArrivalDate, $DepartureDate){
                                    $query->where('dtmResDArrival','>=',$ArrivalDate)
                                          ->where('dtmResDArrival','<=',$DepartureDate);
                                })
                                ->orWhere(function($query) use($ArrivalDate, $DepartureDate){
                                    $query->where('dtmResDDeparture','>=',$ArrivalDate)
                                          ->where('dtmResDDeparture','<=',$DepartureDate);
                                })
                                ->where(function($query) use($ArrivalDate, $DepartureDate){
                                    $query->where('dtmResDArrival','<=',$ArrivalDate)
                                          ->where('dtmResDDeparture','>=',$ArrivalDate);
                                })
                                ->orWhere(function($query) use($ArrivalDate, $DepartureDate){
                                    $query->where('dtmResDArrival','<=',$DepartureDate)
                                          ->where('dtmResDDeparture','>=',$DepartureDate);
                                })
                                ->pluck('strReservationID')
                                ->toArray();
        
        $ExistingRooms = DB::table('tblReservationRoom')
                                ->whereIn('strResRReservationID', $ExistingReservations)
                                ->pluck('strResRRoomID')
                                ->toArray();
        
        $tempArrivalDate = explode(" ", $ArrivalDate);
        $tempDepartureDate = explode(" ", $DepartureDate);
        
        if($tempArrivalDate[0] != $tempDepartureDate[0]){
            $Rooms = DB::table('tblRoom as a')
                        ->join ('tblRoomType as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
                        ->join ('tblRoomRate as c', 'a.strRoomTypeID', '=' , 'c.strRoomTypeID')
                        ->select('b.strRoomType', 
                         'c.dblRoomRate', 
                         'b.intRoomTCapacity', 
                         DB::raw("COUNT(a.strRoomTypeID) as TotalRooms"))
                         ->whereNotIn('strRoomID', $ExistingRooms)
                         ->where([['a.strRoomStatus','=','Available'],['c.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],['b.intRoomTCategory', '=', 1]])
                         ->groupBy('b.strRoomType','c.dblRoomRate', 'b.intRoomTCapacity')
                         ->get();
        }
        else{
            $Rooms = DB::table('tblRoom as a')
                        ->join ('tblRoomType as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
                        ->join ('tblRoomRate as c', 'a.strRoomTypeID', '=' , 'c.strRoomTypeID')
                        ->select('b.strRoomType', 
                         'c.dblRoomRate', 
                         'b.intRoomTCapacity', 
                         DB::raw("COUNT(a.strRoomTypeID) as TotalRooms"))
                         ->whereNotIn('strRoomID', $ExistingRooms)
                         ->where([['a.strRoomStatus','=','Available'],['c.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")]])
                         ->groupBy('b.strRoomType','c.dblRoomRate', 'b.intRoomTCapacity')
                         ->get();
        }
        return $Rooms;
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
    
    public function getAvailableItems(){
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
        
        $tempPackageItems = DB::table('tblPackageItem as a')
                        ->join ('tblAvailPackage as b', 'a.strPackageIPackageID', '=', 'b.strAvailPackageID')
                        ->join ('tblItem as c', 'c.strItemID', '=' , 'a.strPackageIItemID')
                        ->join ('tblReservationDetail as d', 'd.strReservationID', '=' , 'b.strAvailPReservationID')
                        ->join ('tblCustomer as e', 'd.strResDCustomerID', '=' , 'e.strCustomerID')
                        ->select('c.strItemName',
                                 DB::raw('CONCAT(e.strCustFirstName , " " , e.strCustLastName) AS Name'),
                                 'a.intPackageIQuantity',
                                 'a.flPackageIDuration',
                                 'c.intItemQuantity',
                                 'c.strItemID',
                                 'd.strReservationID')
                        ->where('d.intResDStatus', '=', 4)
                        ->get();
        
        $RentedPackageItems = DB::table('tblPayment')
                            ->select('strPayReservationID',
                                     'strPaymentRemarks')
                            ->where('strPayTypeID', '=', 26)
                            ->get();
        
        
        
        foreach($tempPackageItems as $Package){
            foreach($RentedPackageItems as $Rent){
                if($Package->strReservationID == $Rent->strPayReservationID){
                    $tempRentedItem = DB::table('tblRentedItem')
                                      ->where('strRentedItemID', '=', $Rent->strPaymentRemarks)
                                      ->get();
 
                    foreach($tempRentedItem as $tempRent){
                        if($tempRent->strRentedIReservationID == $Package->strReservationID){
                            if($tempRent->strRentedIItemID == $Package->strItemID){
                                $Package->intPackageIQuantity = $Package->intPackageIQuantity - $tempRent->intRentedIQuantity;
                            }
                        }           
                    }
                }   
            }
        }
        
        $PackageItems = $tempPackageItems->where('intPackageIQuantity' ,"!=", 0);
 
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
      

        $Guests = DB::table('tblReservationDetail as a')
                        ->join ('tblCustomer as b', 'a.strResDCustomerID', '=' , 'b.strCustomerID')
                        ->select(DB::raw('CONCAT(b.strCustFirstName , " " , b.strCustLastName) AS Name'))
                        ->where('a.intResDStatus', '=', '4')
                        ->orderBy('Name')
                        ->get();
        
        
        
        return view('ItemRental', compact('RentalItems', 'Guests', 'RentedItems', 'BrokenItems', 'PackageItems'));
    }
    
    
    
    /*---------- BOAT SCHEDULE ----------*/

    public function getAvailableBoats(){

        $dtmNow = Carbon::now('Asia/Manila');

        $dtmDate = $dtmNow->toDateString();
        $dtmTime = $dtmNow->toTimeString();

        $ScheduledBoats =  DB::Select("
            SELECT strBoatSBoatID
            FROM tblBoatSchedule
            WHERE intBoatSStatus = 1
            AND DATE(dtmBoatSPickUp) = '$dtmDate'
            AND '$dtmTime' BETWEEN TIME(DATE_SUB(dtmBoatSPickUp, INTERVAL 1 HOUR)) AND TIME(dtmBoatSPickUp)
            OR '$dtmTime' BETWEEN TIME(dtmBoatSPickUp) AND TIME(DATE_ADD(dtmBoatSPickUp, INTERVAL 1 HOUR))
            UNION
            SELECT strBoatSBoatID
            FROM tblBoatSchedule
            WHERE intBoatSStatus = 1
            AND DATE(dtmBoatSDropoff) = '$dtmDate'
            AND '$dtmTime' BETWEEN TIME(DATE_SUB(dtmBoatSDropoff, INTERVAL 1 HOUR)) AND TIME(dtmBoatSDropoff)
            OR '$dtmTime' BETWEEN TIME(dtmBoatSDropoff) AND TIME(DATE_ADD(dtmBoatSDropoff, INTERVAL 1 HOUR))
        ");
        
        $UnavailableBoats = [];
        foreach($ScheduledBoats as $Boat){
            $UnavailableBoats[sizeof($UnavailableBoats)] = $Boat->strBoatSBoatID;
        }
        
        $AvailableBoats = DB::table('tblBoat as a')
             ->join ('tblBoatRate as b', 'a.strBoatID', '=' , 'b.strBoatID')
                ->select('a.strBoatID', 
                         'a.strBoatName',
                         'a.intBoatCapacity',
                         'b.dblBoatRate',
                         'a.strBoatStatus',
                         'a.strBoatDescription')
                ->whereNotIn('a.strBoatID', $UnavailableBoats)
                ->where([['a.strBoatStatus', "=", 'Available'], ['b.dtmBoatRateAsOf',"=", DB::raw("(SELECT max(dtmBoatRateAsOf) FROM tblBoatRate WHERE strBoatID = a.strBoatID)")]])
                ->orderBy('a.intBoatCapacity')
                ->get();

        $RentedBoats = DB::table('tblBoatSchedule as a')
            ->join('tblBoat as b', 'a.strBoatSBoatID', '=', 'b.strBoatID')
            ->join('tblReservationDetail as d', 'a.strBoatSReservationID', '=', 'd.strReservationID')
            ->join('tblCustomer as c', 'd.strResDCustomerID', '=', 'c.strCustomerID')
            ->where([['a.intBoatSStatus', '=', 1],['a.strBoatSPurpose', '!=', 'Reservation']])
            ->select(
                'a.strBoatScheduleID',
                'a.strBoatSBoatID', 
                'b.strBoatName', 
                'a.dtmBoatSPickUp', 
                'a.dtmBoatSDropOff', 
                DB::raw('CONCAT(c.strCustFirstName, " ", c.strCustLastName) AS strCustomerName'))
            ->get();

        foreach($RentedBoats as $RentedBoat){
            $dtmBoatSPickUp = $RentedBoat->dtmBoatSPickUp;
            $dtmBoatSDropOff = $RentedBoat->dtmBoatSDropOff;

            //Pick Up Date Time
            $dtmBoatSPickUp = explode(" ", $dtmBoatSPickUp);
            $dateBoatSPickUp = explode("-", $dtmBoatSPickUp[0]);
            $timeBoatSPickUp = explode(":", $dtmBoatSPickUp[1]);

            //Drop Off Date Time
            $dtmBoatSDropOff = explode(" ", $dtmBoatSDropOff);
            $dateBoatSDropOff = explode("-", $dtmBoatSDropOff[0]);
            $timeBoatSDropOff = explode(":", $dtmBoatSDropOff[1]);

            $dtPickUp = Carbon::create($dateBoatSPickUp[0], $dateBoatSPickUp[1], $dateBoatSPickUp[2], $timeBoatSPickUp[0], $timeBoatSPickUp[1], $timeBoatSPickUp[2]);
            $dtDropOff = Carbon::create($dateBoatSDropOff[0], $dateBoatSDropOff[1], $dateBoatSDropOff[2], $timeBoatSDropOff[0], $timeBoatSDropOff[1], $timeBoatSDropOff[2]);

            $RentedBoat->dtmBoatSPickUp = $dtPickUp->format('h:i A');
            $RentedBoat->dtmBoatSDropOff = $dtDropOff->format('h:i A');
        }

        $ActiveCustomers = DB::table('tblCustomer as a')
        ->join('tblReservationDetail as b', 'a.strCustomerID', '=', 'b.strResDCustomerID')
        ->select('a.strCustomerID', 'a.strCustFirstName', 'a.strCustLastName')
        ->where('b.intResDStatus', '=', 4)
        ->get();

        $ReservedBoats = DB::table('tblBoatSchedule as a')
            ->join('tblBoat as b', 'a.strBoatSBoatID', '=', 'b.strBoatID')
            ->join('tblReservationDetail as d', 'a.strBoatSReservationID', '=', 'd.strReservationID')
            ->join('tblCustomer as c', 'd.strResDCustomerID', '=', 'c.strCustomerID')
            ->where([
                ['a.strBoatSPurpose', '=', 'Reservation'],
                ['a.intBoatSStatus', '=', 1]])
            ->select(
                'a.strBoatScheduleID',
                'a.strBoatSBoatID', 
                'b.strBoatName', 
                'a.dtmBoatSPickUp', 
                'a.dtmBoatSDropOff', 
                DB::raw('CONCAT(c.strCustFirstName, " ", c.strCustLastName) AS strCustomerName'))
            ->get();

        foreach($ReservedBoats as $ReservedBoat){
            $dtmBoatSPickUp = $ReservedBoat->dtmBoatSPickUp;
            $dtmBoatSDropOff = $ReservedBoat->dtmBoatSDropOff;

            //Pick Up Date Time
            $dtmBoatSPickUp = explode(" ", $dtmBoatSPickUp);
            $dateBoatSPickUp = explode("-", $dtmBoatSPickUp[0]);
            $timeBoatSPickUp = explode(":", $dtmBoatSPickUp[1]);

            //Drop Off Date Time
            $dtmBoatSDropOff = explode(" ", $dtmBoatSDropOff);
            $dateBoatSDropOff = explode("-", $dtmBoatSDropOff[0]);
            $timeBoatSDropOff = explode(":", $dtmBoatSDropOff[1]);

            $dtPickUp = Carbon::create($dateBoatSPickUp[0], $dateBoatSPickUp[1], $dateBoatSPickUp[2], $timeBoatSPickUp[0], $timeBoatSPickUp[1], $timeBoatSPickUp[2]);
            $dtDropOff = Carbon::create($dateBoatSDropOff[0], $dateBoatSDropOff[1], $dateBoatSDropOff[2], $timeBoatSDropOff[0], $timeBoatSDropOff[1], $timeBoatSDropOff[2]);

            $ReservedBoat->dtmBoatSPickUp = $dtPickUp->toDayDateTimeString();
            $ReservedBoat->dtmBoatSDropOff = $dtDropOff->toDayDateTimeString();
        }

        return view('BoatSchedule', compact('AvailableBoats', 'ActiveCustomers', 'RentedBoats', 'ReservedBoats'));

    }
    
    
    /*----------------- ACTIVITIES ------------*/
    
     //Activities
    
    public function getAvailableActivities(){
        $Activities = DB::table('tblBeachActivity as a')
                ->join ('tblBeachActivityRate as b', 'a.strBeachActivityID', '=' , 'b.strBeachActivityID')
                ->select('a.strBeachActivityID',
                         'a.strBeachAName',
                         'a.strBeachAStatus',
                         'b.dblBeachARate',
                         'a.intBeachABoat',
                         'a.strBeachADescription')
                ->where([['b.dtmBeachARateAsOf',"=", DB::raw("(SELECT max(dtmBeachARateAsOf) FROM tblBeachActivityRate WHERE strBeachActivityID = a.strBeachActivityID)")],['a.strBeachAStatus', '=', 'Available']])
                ->get();
    
        foreach ($Activities as $Activity) {

            if($Activity->intBeachABoat == '1'){
                $Activity->intBeachABoat = 'Yes';
            }
            else{
                $Activity->intBeachABoat = 'No';
            }

        }
        
        $dtmNow = Carbon::now('Asia/Manila');

        $dtmDate = $dtmNow->toDateString();
        $dtmTime = $dtmNow->toTimeString();

        $ScheduledBoats =  DB::Select("
            SELECT strBoatSBoatID
            FROM tblBoatSchedule
            WHERE intBoatSStatus = 1
            AND DATE(dtmBoatSPickUp) = '$dtmDate'
            AND NOT '$dtmTime' >= TIME(DATE_ADD(dtmBoatSPickUp, INTERVAL 1 HOUR)) AND NOT '$dtmTime' <= TIME(DATE_SUB(dtmBoatSPickUp, INTERVAL 1 HOUR))
            OR DATE(dtmBoatSDropOff) =  '$dtmDate'
            AND NOT '$dtmTime' >= TIME(DATE_ADD(dtmBoatSDropOff, INTERVAL 1 HOUR)) AND NOT '$dtmTime' <= TIME(DATE_SUB(dtmBoatSDropOff, INTERVAL 1 HOUR))
        ");
        
        $UnavailableBoats = [];
        foreach($ScheduledBoats as $Boat){
            $UnavailableBoats[sizeof($UnavailableBoats)] = $Boat->strBoatSBoatID;
        }
        
        $BoatsAvailable = DB::table('tblBoat as a')
             ->join ('tblBoatRate as b', 'a.strBoatID', '=' , 'b.strBoatID')
                ->select('a.strBoatID', 
                         'a.strBoatName',
                         'a.intBoatCapacity',
                         'b.dblBoatRate',
                         'a.strBoatStatus',
                         'a.strBoatDescription')
                ->whereNotIn('a.strBoatID', $UnavailableBoats)
                ->where([['a.strBoatStatus', "=", 'Available'], ['b.dtmBoatRateAsOf',"=", DB::raw("(SELECT max(dtmBoatRateAsOf) FROM tblBoatRate WHERE strBoatID = a.strBoatID)")]])
                ->orderBy('a.intBoatCapacity')
                ->get();

        $Guests = DB::table('tblReservationDetail as a')
                ->join ('tblCustomer as b', 'a.strResDCustomerID', '=' , 'b.strCustomerID')
                ->select(DB::raw('CONCAT(b.strCustFirstName , " " , b.strCustLastName) AS Name'),
                        'a.strReservationID')
                ->where('a.intResDStatus', '=', '4')
                ->orderBy('Name')
                ->get();
        
        $AvailedActivities = DB::table('tblAvailBeachActivity as a')
                ->join ('tblReservationDetail as b', 'a.strAvailBAReservationID', '=' , 'b.strReservationID')
                ->join ('tblCustomer as c', 'b.strResDCustomerID', '=' , 'c.strCustomerID')
                ->join ('tblBeachActivity as d', 'd.strBeachActivityID', '=' , 'a.strAvailBABeachActivityID')
                ->join ('tblBoatSchedule as e', 'e.strBoatSReservationID', '=' , 'b.strReservationID')
                ->join ('tblBoat as f', 'f.strBoatID', '=' , 'e.strBoatSBoatID')
                ->select('d.strBeachAName',
                         DB::raw('CONCAT(c.strCustFirstName , " " , c.strCustLastName) AS Name'),
                         'f.strBoatName',
                         'e.dtmBoatSPickUp',
                         'e.dtmBoatSDropOff',
                         'e.strBoatScheduleID')
                ->where([['e.intBoatSStatus', '=', '1'], ['a.strAvailBABoatID', '!=', null]])
                ->get();
        
        $tempPackageActivities = DB::table('tblPackageActivity as a')
                        ->join ('tblAvailPackage as b', 'a.strPackageAPackageID', '=', 'b.strAvailPackageID')
                        ->join ('tblBeachActivity as c', 'c.strBeachActivityID', '=' , 'a.strPackageABeachActivityID')
                        ->join ('tblReservationDetail as d', 'd.strReservationID', '=' , 'b.strAvailPReservationID')
                        ->join ('tblCustomer as e', 'd.strResDCustomerID', '=' , 'e.strCustomerID')
                        ->select('c.strBeachAName',
                                 DB::raw('CONCAT(e.strCustFirstName , " " , e.strCustLastName) AS Name'),
                                 'a.intPackageAQuantity',
                                 'c.strBeachActivityID',
                                 'c.intBeachABoat',
                                 'd.strReservationID')
                        ->where('d.intResDStatus', '=', 4)
                        ->get();
        
        $RentedPackageActivities = DB::table('tblPayment')
                            ->select('strPayReservationID',
                                     'strPaymentRemarks')
                            ->where('strPayTypeID', '=', 27)
                            ->get();
        
        
        
        foreach($tempPackageActivities as $Package){
            foreach($RentedPackageActivities as $Rent){
                if($Package->strReservationID == $Rent->strPayReservationID){
                    $tempAvailedActivities = DB::table('tblAvailBeachActivity')
                                      ->where('strAvailBeachActivityID', '=', $Rent->strPaymentRemarks)
                                      ->get();
 
                    foreach($tempAvailedActivities as $tempAvailed){
                        if($tempAvailed->strAvailBAReservationID == $Package->strReservationID){
                            if($tempAvailed->strAvailBABeachActivityID== $Package->strBeachActivityID){
                                $Package->intPackageAQuantity = $Package->intPackageAQuantity - $tempAvailed->intAvailBAQuantity;
                            }
                        }           
                    }
                }   
            }
        }
        
        $PackageActivities = $tempPackageActivities->where('intPackageAQuantity' ,"!=", 0);
        
        return view('Activities', compact('Activities', 'Guests', 'BoatsAvailable', 'AvailedActivities', 'PackageActivities'));
    }
    
    
    /*----------------- FEES -----------------*/
    
    public function ViewFees(){
        $CustomerResort = DB::table('tblCustomer as a')
                            ->join ('tblReservationDetail as b', 'b.strResDCustomerID', '=' , 'a.strCustomerID')
                            ->where([['a.intCustStatus', 1],['b.intResDStatus', '=', '4']])
                            ->get();
        
        $Fees = DB::table('tblFee')
                ->select('strFeeID',
                         'strFeeName')
                ->where('strFeeStatus', '=', 'Active')
                ->get();
        
        return view('Fees', compact('CustomerResort', 'Fees'));
    }
    
    public function GetFeeDetails(Request $req){
        $ReservationID = trim($req->input('ReservationID'));
        
        $CustomerFees = DB::table('tblReservationFee as a')
             ->join ('tblFee as b', 'a.strResFFeeID', '=' , 'b.strFeeID')
                ->select('b.strFeeID', 
                         'b.strFeeName',
                         'a.intResFQuantity')
                ->where([['a.intResFPayment', '=', 0],['a.strResFReservationID', '=', $ReservationID]])
                ->get();
        
        return response()->json($CustomerFees);
    }
    
    public function GetFeePrice(Request $req){
        $FeeID = trim($req->input('FeeID'));
        
        $FeeAmount = DB::table('tblFee as a')
                ->join ('tblFeeAmount as b', 'a.strFeeID', '=' , 'b.strFeeID')
                ->select('b.dblFeeAmount')
                ->where([['b.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")],['a.strFeeID', "=", $FeeID]])
                ->get();
        
        return response()->json($FeeAmount);
    }
    
    public function getPackageFees(Request $req){
        $ReservationID = trim($req->input('ReservationID'));
        $PackageFees = DB::table('tblPackageFee as a')
                        ->join ('tblAvailPackage as b', 'a.strPackageFPackageID', '=', 'b.strAvailPackageID')
                        ->join ('tblFee as c', 'c.strFeeID', '=' , 'a.strPackageFFeeID')
                        ->join ('tblReservationDetail as d', 'd.strReservationID', '=' , 'b.strAvailPReservationID')
                        ->join ('tblCustomer as e', 'd.strResDCustomerID', '=' , 'e.strCustomerID')
                        ->select('c.strFeeID',
                                 'c.strFeeName')
                        ->where([['d.intResDStatus', '=', 4],['d.strReservationID', '=', $ReservationID]])
                        ->get();
        
         return response()->json($PackageFees);
    }
    
    
    /*---------------- BILLING ------------------*/
    
    public function ViewBilling(){
        $ReservationInfo = DB::table('tblReservationDetail as a')
                        ->join ('tblCustomer as b', 'a.strResDCustomerID', '=' , 'b.strCustomerID')
                        ->select('a.strReservationID',
                                 DB::raw('CONCAT(b.strCustFirstName , " " , b.strCustLastName) AS Name'),
                                 'a.dtmResDArrival',
                                 'a.dtmResDDeparture',
                                 DB::raw('b.strCustEmail AS TotalBill'))
                        ->where('a.intResDStatus', '=', '4')
                        ->get();
        
        foreach($ReservationInfo as $Info){
            $TotalRoom = 0;
            $TotalItem = 0;
            $TotalActivity = 0;
            $TotalFee = 0;
            $TotalPenalty = 0;
            $TotalBoat = 0;
            $TimePenalties = 0;
            $BrokenPenalties = 0;
            $TotalExtend = 0;
            $AdditionalRoomAmount = 0;
            $UpgradeRoomAmount = 0;
            $PackagePayment = 0;
            $PackageInitialBill = 0;
            $PackageInitialPayment = 0;
            $PackageDownPayment = 0;
            $ExtendStayAmount = 0;
            
            //Compute Rooms
            $ReservedRooms = DB::table('tblRoom as a')
                            ->join ('tblRoomType as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
                            ->join ('tblRoomRate as c', 'a.strRoomTypeID', '=' , 'c.strRoomTypeID')
                            ->join ('tblReservationRoom as d', 'a.strRoomID', '=', 'd.strResRRoomID')
                             ->where([['a.strRoomStatus','=','Available'],['c.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],['d.strResRReservationID', '=', $Info->strReservationID], ['intResRPayment', '=', 0]])
                             ->pluck('c.dblRoomRate')
                             ->toArray();
            
            for($x = 0; $x < sizeof($ReservedRooms); $x++){
                $TotalRoom += $ReservedRooms[$x];
            }
            
            $ArrivalDate = Carbon::parse($Info->dtmResDArrival);
            $DepartureDate = Carbon::parse($Info->dtmResDDeparture);
            
            $DaysOfStay = $ArrivalDate->diffInDays($DepartureDate);
            
            if($DaysOfStay == 0){
                $DaysOfStay = 1;
            }
            
            //Package Computation
            $PackageExist = DB::table('tblAvailPackage')
                            ->where('strAvailPReservationID', '=', $Info->strReservationID)
                            ->get();
            
            if(sizeof($PackageExist) > 0){
                $PackageInitialBill = DB::table('tblPayment')
                                    ->where([['strPayReservationID', '=', $Info->strReservationID],['strPayTypeID', '=', 1]])
                                    ->pluck('dblPayAmount')
                                    ->first();
                
                $PackageDownPayment = DB::table('tblPayment')
                                    ->where([['strPayReservationID', '=', $Info->strReservationID],['strPayTypeID', '=', 2]])
                                    ->pluck('dblPayAmount')
                                    ->first();
                
                if($PackageDownPayment != null){
                    $PackageInitialBill = (int)$PackageInitialBill - (int)$PackageDownPayment;
                }
                
                $PackageInitialPayment = DB::table('tblPayment')
                                    ->where([['strPayReservationID', '=', $Info->strReservationID],['strPayTypeID', '=', 3]])
                                    ->pluck('dblPayAmount')
                                    ->first();
                
                if($PackageInitialPayment != null){
                    $PackagePayment = 0;
                }
                else{
                    $PackagePayment = $PackageInitialBill;
                }
            }
            
            $TotalRoom = $TotalRoom * $DaysOfStay;
            
            //Additional Rooms
            $AdditionalRoomBills = DB::table('tblPayment')
                            ->where([['strPayReservationID', '=', $Info->strReservationID],['strPayTypeID', '=', 20]])
                            ->get();
            
            foreach($AdditionalRoomBills as $Bill){
                $AdditionalRoomAmount += $Bill->dblPayAmount;
            }
            
            
            //Upgrade Rooms
            $UpgradeRoomBills = DB::table('tblPayment')
                            ->where([['strPayReservationID', '=', $Info->strReservationID],['strPayTypeID', '=', 22]])
                            ->get();
            
            foreach($UpgradeRoomBills as $Bill){
                $UpgradeRoomAmount += $Bill->dblPayAmount;
            }
            
            //Days Extend
            $ExtendStayBills = DB::table('tblPayment')
                            ->where([['strPayReservationID', '=', $Info->strReservationID],['strPayTypeID', '=', 20]])
                            ->get();
            
            foreach($ExtendStayBills as $Bill){
                $ExtendStayAmount += $Bill->dblPayAmount;
            }
                
            //Compute Item
            $RentedItems = DB::table('tblItem as a')
                        ->join ('tblItemRate as b', 'a.strItemID', '=' , 'b.strItemID')
                        ->join ('tblRentedItem as c', 'a.strItemID', '=', 'c.strRentedIItemID')
                        ->select('b.dblItemRate',
                                 'c.intRentedIQuantity',
                                 'c.intRentedIDuration')
                        ->where([['b.dtmItemRateAsOf',"=", DB::raw("(SELECT max(dtmItemRateAsOf) FROM tblItemRate WHERE strItemID = a.strItemID)")],['c.strRentedIReservationID',"=", $Info->strReservationID],['c.intRentedIPayment',"=", 0]])
                        ->get();
            
            foreach($RentedItems as $Item){
                $TotalItem += ($Item->dblItemRate * $Item->intRentedIQuantity) * $Item->intRentedIDuration;
            }
            
            //Compute Activities
            $AvailedActivities = DB::table('tblBeachActivity as a')
                                ->join ('tblBeachActivityRate as b', 'a.strBeachActivityID', '=' , 'b.strBeachActivityID')
                                ->join ('tblAvailBeachActivity as c', 'c.strAvailBABeachActivityID', '=', 'b.strBeachActivityID')
                                ->select('b.dblBeachARate',
                                         'c.intAvailBAQuantity')
                                ->where([['b.dtmBeachARateAsOf',"=", DB::raw("(SELECT max(dtmBeachARateAsOf) FROM tblBeachActivityRate WHERE strBeachActivityID = a.strBeachActivityID)")],['c.strAvailBAReservationID', '=', $Info->strReservationID]])
                                ->get();
            
            foreach($AvailedActivities as $Activity){
                $TotalActivity += $Activity->dblBeachARate * $Activity->intAvailBAQuantity;
            }
            
            //Compute Fees
            $AvailedFees = DB::table('tblFee as a')
                            ->join ('tblFeeAmount as b', 'a.strFeeID', '=' , 'b.strFeeID')
                            ->join ('tblReservationFee as c', 'c.strResFFeeID', '=', 'a.strFeeID')
                            ->select('b.dblFeeAmount',
                                     'c.intResFQuantity')
                            ->where([['b.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")],['c.strResFReservationID', '=', $Info->strReservationID], ['c.intResFPayment', '=', 0]])
                            ->get();
            
            foreach($AvailedFees as $Fee){
                $TotalFee += $Fee->dblFeeAmount * $Fee->intResFQuantity;
            }
            
            //Time Penalties
            $TimePenaltyBills = DB::table('tblPayment')
                            ->where([['strPayReservationID', '=', $Info->strReservationID],['strPayTypeID', '=', 6]])
                            ->get();
            
            foreach($TimePenaltyBills as $Bill){
                $TimePenalties += $Bill->dblPayAmount;
            }
            
            //Broken Penalties
            $BrokenPenaltyBills = DB::table('tblPayment')
                            ->where([['strPayReservationID', '=', $Info->strReservationID],['strPayTypeID', '=', 7]])
                            ->get();
            
            foreach($BrokenPenaltyBills as $Bill){
                $BrokenPenalties += $Bill->dblPayAmount;
            }
            
            //Extend Item Rental Bills
            $ExtendBills = DB::table('tblPayment')
                            ->where([['strPayReservationID', '=', $Info->strReservationID],['strPayTypeID', '=', 10]])
                            ->get();
            
       
            foreach($ExtendBills as $Bill){
                $TotalExtend += $Bill->dblPayAmount;
            }
            
            //Total Penalties
            $TotalPenalties = $TotalExtend + $BrokenPenalties + $TimePenalties;
            
            //Compute Boat Rental
            
            $Info->TotalBill = $TotalPenalties + $TotalFee + $TotalActivity + $TotalItem + $TotalRoom + $AdditionalRoomAmount + $UpgradeRoomAmount + $PackagePayment + $ExtendStayAmount;
        }

        return view('Billing', compact('ReservationInfo'));
    }
    
    public function getBillBreakdown(Request $req){
        $ReservationID = trim($req->input('id'));

        $RoomInfo = DB::table('tblRoom as a')
                    ->join ('tblRoomType as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
                    ->join ('tblRoomRate as c', 'a.strRoomTypeID', '=' , 'c.strRoomTypeID')
                    ->join ('tblReservationRoom as d', 'a.strRoomID', '=', 'd.strResRRoomID')
                    ->select('b.strRoomType',
                             'a.strRoomName',
                             'c.dblRoomRate')
                     ->where([['a.strRoomStatus','=','Available'],['c.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],['d.strResRReservationID', '=', $ReservationID], ['intResRPayment', '=', 0]])
                     ->get();
        
        $ItemInfo = DB::table('tblItem as a')
                    ->join ('tblItemRate as b', 'a.strItemID', '=' , 'b.strItemID')
                    ->join ('tblRentedItem as c', 'a.strItemID', '=', 'c.strRentedIItemID')
                    ->select('b.dblItemRate',
                             'c.intRentedIQuantity',
                             'c.intRentedIDuration',
                             'a.strItemName')
                    ->where([['b.dtmItemRateAsOf',"=", DB::raw("(SELECT max(dtmItemRateAsOf) FROM tblItemRate WHERE strItemID = a.strItemID)")],['c.strRentedIReservationID',"=", $ReservationID],['c.intRentedIPayment',"=", 0]])
                    ->get();
        
        $ActivityInfo = DB::table('tblBeachActivity as a')
                    ->join ('tblBeachActivityRate as b', 'a.strBeachActivityID', '=' , 'b.strBeachActivityID')
                    ->join ('tblAvailBeachActivity as c', 'c.strAvailBABeachActivityID', '=', 'b.strBeachActivityID')
                    ->select('b.dblBeachARate',
                             'c.intAvailBAQuantity',
                             'a.strBeachAName')
                    ->where([['b.dtmBeachARateAsOf',"=", DB::raw("(SELECT max(dtmBeachARateAsOf) FROM tblBeachActivityRate WHERE strBeachActivityID = a.strBeachActivityID)")],['c.strAvailBAReservationID', '=', $ReservationID]])
                    ->get();
        
        $FeeInfo = DB::table('tblFee as a')
                    ->join ('tblFeeAmount as b', 'a.strFeeID', '=' , 'b.strFeeID')
                    ->join ('tblReservationFee as c', 'c.strResFFeeID', '=', 'a.strFeeID')
                    ->select('b.dblFeeAmount',
                             'c.intResFQuantity',
                             'a.strFeeName')
                    ->where([['b.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")],['c.strResFReservationID', '=', $ReservationID],['c.intResFPayment', '=', 0]])
                    ->get();

        $MiscellaneousInfo = DB::table('tblPayment as a')
                    ->join ('tblPaymentType as b', 'a.strPayTypeID', '=', 'b.strPaymentTypeID')
                    ->select('a.dblPayAmount',
                             'b.strPaymentType',
                             'a.strPaymentRemarks')
                    ->where('strPayReservationID', '=', $ReservationID)
                    ->where('strPayTypeID', '=', 6)
                    ->orWhere('strPayTypeID', '=', 7)
                    ->orWhere('strPayTypeID', '=', 10)
                    ->get();
        
        $AdditionalRooms = DB::table('tblRoom as a')
                    ->join ('tblRoomType as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
                    ->join ('tblRoomRate as c', 'a.strRoomTypeID', '=' , 'c.strRoomTypeID')
                    ->join ('tblReservationRoom as d', 'a.strRoomID', '=', 'd.strResRRoomID')
                    ->select('b.strRoomType',
                             'a.strRoomName',
                             'c.dblRoomRate')
                     ->where([['a.strRoomStatus','=','Available'],['c.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],['d.strResRReservationID', '=', $ReservationID], ['intResRPayment', '=', 2]])
                     ->get();
        
        $UpgradeRooms = DB::table('tblPayment as a')
                    ->join ('tblPaymentType as b', 'a.strPayTypeID', '=', 'b.strPaymentTypeID')
                    ->select('a.dblPayAmount',
                             'a.strPaymentRemarks')
                    ->where([['strPayReservationID', '=', $ReservationID],['strPayTypeID', '=', 22]])
                    ->get();
        
        //Package Computation
        $PackageInfo = DB::table('tblAvailPackage as a')
                        ->join('tblPackage as b', 'b.strPackageID', '=', 'a.strAvailPackageID')
                        ->select('b.strPackageName',
                                 'b.intPackagePax')
                        ->where('a.strAvailPReservationID', '=', $ReservationID)
                        ->get();
        
        $PackageInitialBill = 0;
        $PackageDownPayment = 0;
        $PackageInitialPayment = 0;

        if(sizeof($PackageInfo) > 0){
            $PackageInitialBill = DB::table('tblPayment')
                                ->where([['strPayReservationID', '=', $ReservationID],['strPayTypeID', '=', 1]])
                                ->pluck('dblPayAmount')
                                ->first();

            $PackageDownPayment = DB::table('tblPayment')
                                ->where([['strPayReservationID', '=', $ReservationID],['strPayTypeID', '=', 2]])
                                ->pluck('dblPayAmount')
                                ->first();

            if($PackageDownPayment != null){
                $PackageInitialBill = (int)$PackageInitialBill - (int)$PackageDownPayment;
            }

            $PackageInitialPayment = DB::table('tblPayment')
                                ->where([['strPayReservationID', '=', $ReservationID],['strPayTypeID', '=', 3]])
                                ->pluck('dblPayAmount')
                                ->first();

            if($PackageInitialPayment != null){
                $PackagePayment = 0;
            }
            else{
                $PackagePayment = $PackageInitialBill;
            }
            
            foreach($PackageInfo as $Info){
                $Info->intPackagePax = $PackagePayment;
            }
        }
        
        return response()->json(['RoomInfo' => $RoomInfo, 'ItemInfo' => $ItemInfo, 'ActivityInfo' => $ActivityInfo, 'FeeInfo' => $FeeInfo, 'MiscellaneousInfo' => $MiscellaneousInfo, 'AdditionalRooms' => $AdditionalRooms, 'UpgradeRooms' => $UpgradeRooms,'PackageInfo' => $PackageInfo]);
    }
    
    
    
}
