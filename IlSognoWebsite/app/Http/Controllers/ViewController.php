<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class ViewController extends Controller
{
    //
    
    //Accomodation
    public function getRooms(){
        $RoomTypes = DB::table('tblRoomType as a')
            ->join ('tblRoomRate as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
            ->select('a.strRoomTypeID', 
                     'a.strRoomType', 
                     'a.intRoomTCapacity', 
                     'a.intRoomTNoOfBeds', 
                     'a.intRoomTNoOfBathrooms', 
                     'a.intRoomTAirconditioned', 
                     'b.dblRoomRate', 
                     'a.strRoomDescription',
                     'a.intRoomTCategory',
                     DB::raw("b.dtmRoomRateAsOf AS RoomImage"))
            ->where([['b.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],
                    ['a.intRoomTDeleted',"=", "1"]])
            ->get();
        
       
        
        foreach ($RoomTypes as $RoomType) {

            if($RoomType->intRoomTAirconditioned == '1'){
                $RoomType->intRoomTAirconditioned = 'Yes';
            }
            else{
                $RoomType->intRoomTAirconditioned = 'No';
            }
            
            if($RoomType->intRoomTCategory == '1'){
                $RoomType->intRoomTCategory = 'Room';
            }
            else{
                $RoomType->intRoomTCategory = 'Cottage';
            }
            
            $RoomPicture = DB::table('tblRoomPicture')
            ->where('strRoomPRoomTID', '=', $RoomType->strRoomTypeID)
            ->pluck("blobRoomPPicture")
            ->first();
            
            if(sizeof($RoomPicture) == 0){
                $RoomType->RoomImage = "/Accommodation/DefaultImage.png";
            }
            else{
                $RoomType->RoomImage = $RoomPicture;
            }
        }


        return view('Accomodation', compact('RoomTypes'));
    }
    
    //Packages
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
                    ->where([['b.dtmPackagePriceAsOf',"=", DB::raw("(SELECT MAX(dtmPackagePriceAsOf) FROM tblPackagePrice WHERE strPackageID = a.strPackageID)")], ['a.strPackageStatus', '=', 'Available']])
                    ->get();
        
        foreach($Packages as $Package){
            if($Package->intBoatFee == 0){
                $Package->intBoatFee = "Not Free";
            }
            else{
                $Package->intBoatFee = "Free";
            }
        }
        
        $PackageRoomInfo = DB::table('tblRoomType as a')
                        ->join('tblPackageRoom as b', 'a.strRoomTypeID', '=', 'b.strPackageRRoomTypeID')
                        ->select('a.strRoomType',
                                 'b.intPackageRQuantity',
                                 'b.strPackageRPackageID')
                        ->groupBy('b.strPackageRPackageID', 'a.strRoomType', 'b.intPackageRQuantity')
                        ->get();
        
        
        $PackageActivityInfo = DB::table('tblBeachActivity as a')
                        ->join('tblPackageActivity as b', 'a.strBeachActivityID', '=', 'b.strPackageABeachActivityID')
                        ->select('a.strBeachAName',
                                 'b.intPackageAQuantity',
                                 'b.strPackageAPackageID')
                        ->groupBy('b.strPackageAPackageID', 'a.strBeachAName', 'b.intPackageAQuantity')
                        ->get();
        
        $PackageItemInfo = DB::table('tblPackageItem as a')
                        ->join('tblItem as b', 'a.strPackageIItemID', '=', 'b.strItemID')
                        ->select('b.strItemName',
                                 'a.intPackageIQuantity',
                                 'a.flPackageIDuration',
                                 'a.strPackageIPackageID')
                        ->groupBy('a.strPackageIPackageID', 'b.strItemName', 'a.intPackageIQuantity', 'a.flPackageIDuration')
                        ->get();
        
        $PackageFeeInfo = DB::table('tblFee as a')
                        ->join('tblPackageFee as b', 'a.strFeeID', '=', 'b.strPackageFFeeID')
                        ->join('tblFeeAmount as c', 'a.strFeeID', '=', 'c.strFeeID')
                        ->select('a.strFeeName',
                                 'c.dblFeeAmount',
                                 'b.strPackageFPackageID')
                        ->where('c.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)"))
                        ->get();
        
        return view('Packages', compact('Packages', 'PackageRoomInfo', 'PackageActivityInfo', 'PackageItemInfo', 'PackageFeeInfo'));
    }
    
    //Activities
    public function getActivities(){
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
        
        return view('Activities', compact('Activities'));
    }
    
    //Packages Room AJAX
    
    public function getRoomInfo(Request $req){
        $RoomType = trim($req->input('RoomName'));
        
        $RoomTypeID = DB::table('tblRoomType')->where([['strRoomType',"=",$RoomType], ['intRoomTDeleted',"=","1"]])->pluck('strRoomTypeID')->first();
        
        $RoomInfo = DB::table('tblRoomType as a')
            ->join ('tblRoomRate as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
            ->select('a.strRoomTypeID', 
                     'a.strRoomType', 
                     'a.intRoomTCapacity', 
                     'a.intRoomTNoOfBeds', 
                     'a.intRoomTNoOfBathrooms', 
                     'a.intRoomTAirconditioned', 
                     'b.dblRoomRate', 
                     'a.strRoomDescription',
                     'a.intRoomTCategory')
            ->where([['b.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],
                    ['a.intRoomTDeleted',"=", "1"], ['a.strRoomTypeID', "=", $RoomTypeID]])
            ->get();
        
        foreach ($RoomInfo as $Info) {

            if($Info->intRoomTAirconditioned == '1'){
                $Info->intRoomTAirconditioned = 'Yes';
            }
            else{
                $Info->intRoomTAirconditioned = 'No';
            }
            
            if($Info->intRoomTCategory == '1'){
                $Info->intRoomTCategory = 'Room';
            }
            else{
                $Info->intRoomTCategory = 'Cottage';
            }

        }
        
        return response()->json($RoomInfo);
    }
    
    //Package Activity AJAX
    
    public function getActivityInfo(Request $req){
        $ActivityName = trim($req->input('ActivityName'));
         
        $ActivityID = DB::table('tblBeachActivity')->where([['strBeachAName','=',$ActivityName], ['strBeachAStatus','=',"Available"]])->pluck('strBeachActivityID')->first();
        
        $ActivityInfo = DB::table('tblBeachActivity as a')
                ->join ('tblBeachActivityRate as b', 'a.strBeachActivityID', '=' , 'b.strBeachActivityID')
                ->select('a.strBeachActivityID',
                         'a.strBeachAName',
                         'a.strBeachAStatus',
                         'b.dblBeachARate',
                         'a.intBeachABoat',
                         'a.strBeachADescription')
                ->where([['b.dtmBeachARateAsOf',"=", DB::raw("(SELECT max(dtmBeachARateAsOf) FROM tblBeachActivityRate WHERE strBeachActivityID = a.strBeachActivityID)")],['a.strBeachAStatus', '=', 'Available'], ['a.strBeachActivityID', '=', $ActivityID]])
                ->get();
    
        foreach ($ActivityInfo as $Activity) {

            if($Activity->intBeachABoat == '1'){
                $Activity->intBeachABoat = 'Yes';
            }
            else{
                $Activity->intBeachABoat = 'No';
            }

        }  
        
        return response()->json($ActivityInfo);
    }
    
    //Package Item AJAX
    
    public function getItemInfo(Request $req){
        $ItemName = trim($req->input('ItemName'));
         
        $ItemID = DB::table('tblItem')->where([['strItemName',$ItemName], ['intItemDeleted',"1"]])->pluck('strItemID')->first();
        
        $ItemInfo = DB::table('tblItem as a')
                ->join ('tblItemRate as b', 'a.strItemID', '=' , 'b.strItemID')
                ->select('a.strItemID',
                         'a.strItemName',
                         'a.intItemQuantity',
                         'b.dblItemRate',
                         'a.strItemDescription')
                ->where([['b.dtmItemRateAsOf',"=", DB::raw("(SELECT max(dtmItemRateAsOf) FROM tblItemRate WHERE strItemID = a.strItemID)")],
                        ['a.intItemDeleted',"=", "1"], ['a.strItemID','=',$ItemID]])
                ->get();   
        
        return response()->json($ItemInfo);
    }
    
    
    //Reservation Room AJAX
    
    public function getAvailableRooms(Request $req){
        $tempArrivalDate = trim($req->input('CheckInDate'));
        $tempDepartureDate = trim($req->input('CheckOutDate'));
        
        $tempArrivalDate2 = explode("/", $tempArrivalDate);
        $tempDepartureDate2 = explode("/", $tempDepartureDate);
        
        $ArrivalDate = $tempArrivalDate2[2] ."/". $tempArrivalDate2[0] ."/". $tempArrivalDate2[1];
        $DepartureDate = $tempDepartureDate2[2] ."/". $tempDepartureDate2[0] ."/". $tempDepartureDate2[1];
        
        $Rooms = DB::select("SELECT b.strRoomType, c.dblRoomRate, b.intRoomTCapacity, COUNT(a.strRoomTypeID) as TotalRooms FROM tblRoom a, tblRoomType b, tblRoomRate c WHERE strRoomID NOT IN(SELECT strResRRoomID FROM tblReservationRoom WHERE strResRReservationID IN(SELECT strReservationID FROM tblReservationDetail WHERE (intResDStatus = 1 OR intResDStatus = 2) AND ((dtmResDDeparture BETWEEN '".$ArrivalDate."' AND '".$DepartureDate."') OR (dtmResDArrival BETWEEN '".$ArrivalDate."' AND '".$DepartureDate."') AND NOT intResDStatus = 3))) AND a.strRoomTypeID = b.strRoomTypeID AND a.strRoomTypeID = c.strRoomTypeID AND a.strRoomStatus = 'Available' AND c.dtmRoomRateAsOf = (SELECT MAX(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID) GROUP BY a.strRoomTypeID, b.strRoomType, c.dblRoomRate, b.intRoomTCapacity");
        
        
        return response()->json($Rooms);
    }
    
    //Reservation Boat AJAX
    
    public function getAvailableBoats(Request $req){
        $tempArrivalDate = trim($req->input('CheckInDate'));
        $DepartureDate = trim($req->input('CheckOutDate'));
        $PickUpTime = trim($req->input('PickUpTime'));
        $TotalGuests = trim($req->input('TotalGuests'));
        
        $tempArrivalDate2 = explode('/', $tempArrivalDate);

        $ArrivalDate = $tempArrivalDate2[2] ."/". $tempArrivalDate2[0] ."/". $tempArrivalDate2[1];
     
        $BoatsAvailable = DB::table('tblBoat as a')
         ->join ('tblBoatRate as b', 'a.strBoatID', '=' , 'b.strBoatID')
            ->select('a.strBoatID', 
                     'a.strBoatName',
                     'a.intBoatCapacity',
                     'b.dblBoatRate',
                     'a.strBoatStatus',
                     'a.strBoatDescription')
            ->whereNotIn('a.strBoatID', [DB::raw("(SELECT strBoatSBoatID FROM tblBoatSchedule WHERE (date(dtmBoatSPickUp) = '".$ArrivalDate."') AND '".$PickUpTime."' BETWEEN time(dtmBoatSPickUp) AND time(DATE_ADD(dtmBoatSPickUp, INTERVAL 1 HOUR)))")])
            ->where([['a.strBoatStatus', "=", 'Available'], ['b.dtmBoatRateAsOf',"=", DB::raw("(SELECT max(dtmBoatRateAsOf) FROM tblBoatRate WHERE strBoatID = a.strBoatID)")]])
            ->orderBy('a.intBoatCapacity')
            ->get();
        
        return response()->json($BoatsAvailable);
    }
    
    //Entrance Fee AJAX
    
    public function getEntranceFee(){
        $Fees = DB::table('tblFee as a')
                ->join ('tblFeeAmount as b', 'a.strFeeID', '=' , 'b.strFeeID')
                ->select('a.strFeeName',
                         'b.dblFeeAmount')
                ->where([['b.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")],['a.strFeeStatus', '!=', 'deleted'],['a.strFeeName', '=', 'Entrance Fee']])
                ->get();
        
        return response()->json($Fees);
    }
    
    public function bookReservation(){
        return view('BookReservation');
    }
}
