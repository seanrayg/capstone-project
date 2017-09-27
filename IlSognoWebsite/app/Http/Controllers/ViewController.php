<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use Carbon\Carbon;

class ViewController extends Controller
{
    //
    
    //Home Page
    public function getHomePage(){
        //HOME PAGE
        $HomePageContents = DB::table('tblWebContent')->where('strPageTitle', 'Home Page')->get();
 
        $HomePagePictures;
        $tempHomePagePictures;
        foreach($HomePageContents as $Content){
            $tempHomePagePictures = json_decode($Content->strBodyImage, true);
        }
        $arrHomePictures = [];
        foreach($tempHomePagePictures as $Picture){
            $arrHomePictures[sizeof($arrHomePictures)] = $Picture;
        }
        
        $HomePagePictures = DB::table('tblWebContent')
                        ->select(DB::raw('strHeaderDescription as HomeBodyImage1'),
                                DB::raw('strBodyDescription as HomeBodyImage2'),
                                DB::raw('strHeaderImage as HomeBodyImage3'))
                        ->where('strPageTitle', 'Home Page')
                        ->get();
        
        foreach($HomePagePictures as $Picture){
            $Picture->HomeBodyImage1 = $arrHomePictures[0];
            $Picture->HomeBodyImage2 = $arrHomePictures[1];
            $Picture->HomeBodyImage3 = $arrHomePictures[2];
            break;
        }
        
        
        return view('index', compact('HomePageContents', 'HomePagePictures'));
    }
    
    
    //Accomodation
    public function getRooms(){
        
        $AccommodationContents = DB::table('tblWebContent')->where('strPageTitle', 'Accommodation')->get();
        
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


        return view('Accomodation', compact('RoomTypes', 'AccommodationContents'));
    }
    
    public function getLocation(){
        $LocationContents = DB::table('tblWebContent')->where('strPageTitle', 'Location')->get();
        
        return view('Location', compact('LocationContents'));
    }
    
    public function getAboutUs(){
        $AboutContents = DB::table('tblWebContent')->where('strPageTitle', 'About Us')->get();
        
        $AboutDescriptions;
        $tempAboutDescriptions;
        foreach($AboutContents as $Content){
            $tempAboutDescriptions = json_decode($Content->strBodyDescription, true);
        }
        $arrAboutDescription = [];
        foreach($tempAboutDescriptions as $Description){
            $arrAboutDescription[sizeof($arrAboutDescription)] = $Description;
        }
        
        $AboutDescriptions = DB::table('tblWebContent')
                        ->select(DB::raw('strHeaderDescription as AboutDescription1'),
                                DB::raw('strBodyImage as AboutDescription2'),
                                DB::raw('strHeaderImage as AboutDescription3'))
                        ->where('strPageTitle', 'About Us')
                        ->get();
        
        foreach($AboutDescriptions as $Descriptions){
            $Descriptions->AboutDescription1 = $arrAboutDescription[0];
            $Descriptions->AboutDescription2 = $arrAboutDescription[1];
            $Descriptions->AboutDescription3 = $arrAboutDescription[2];
            break;
        }
        
        return view('AboutUs', compact('AboutContents', 'AboutDescriptions'));
    }
    
    public function getContactUs(){
        
        $ContactsContents = DB::table('tblWebContent')->where('strPageTitle', 'Contact Us')->get();

        $Contacts = DB::table('tblContact')
                ->where('intContactStatus', '=', '1')
                ->get();
       
        foreach($Contacts as $Contact){
            if($Contact->intContactStatus == 1){
                $Contact->intContactStatus = "Active";
            }
            else{
                $Contact->intContactStatus = "Inactive";
            }
        }
        return view('ContactUs', compact('ContactsContents', 'Contacts'));
    }
    
    //Packages
    public function getPackages(){
        $PackagesContents = DB::table('tblWebContent')->where('strPageTitle', 'Packages')->get();
        
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
        
        return view('Packages', compact('Packages', 'PackageRoomInfo', 'PackageActivityInfo', 'PackageItemInfo', 'PackageFeeInfo', 'PackagesContents'));
    }
    
    //Activities
    public function getActivities(){
        $ActivitiesContents = DB::table('tblWebContent')->where('strPageTitle', 'Activities')->get();
        
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
        
        return view('Activities', compact('Activities', 'ActivitiesContents'));
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
        
        $tempArrivalDate1 = explode(" ", $tempArrivalDate);
        $tempDepartureDate1 = explode(" ", $tempDepartureDate);
        
        $tempArrivalDate2 = explode("/", $tempArrivalDate1[0]);
        $tempDepartureDate2 = explode("/", $tempDepartureDate1[0]);
        
        $ArrivalDate = $tempArrivalDate2[2] ."/". $tempArrivalDate2[0] ."/". $tempArrivalDate2[1] ." ". $tempArrivalDate1[1];
        $DepartureDate = $tempDepartureDate2[2] ."/". $tempDepartureDate2[0] ."/". $tempDepartureDate2[1] ." ". $tempDepartureDate1[1];
        
        $Rooms = $this->fnGetAvailableRooms($ArrivalDate, $DepartureDate);
        
        return response()->json($Rooms);
    }
    
    public function fnGetAvailableRooms($ArrivalDate, $DepartureDate){
           
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

    //Reservation Package AJAX
    public function getAvailablePackages(Request $req){
        $CheckInDate = trim($req->input('CheckInDate'));
        $Packages = $this->fnGetPackages();
        foreach($Packages as $Package){
            
            $CheckOutDate = carbon::parse($CheckInDate)->addDays($Package->intPackageDuration)->toDateTimeString();
            $CheckOutDate = str_replace('-','/', $CheckOutDate);
            
            $Rooms = $this->fnGetAvailableRooms($CheckInDate, $CheckOutDate);
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
        
        return response()->json($newPackage);
    }

     public function fnGetPackages(){
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

    public function getReservation($id){
        $PackageInfo = DB::table('tblAvailPackage as a')
                    ->join('tblPackage as b', 'b.strPackageID', '=', 'a.strAvailPackageID')
                    ->join ('tblPackagePrice as c', 'b.strPackageID', '=' , 'c.strPackageID')
                    ->select('b.strPackageID',
                             'b.strPackageName',
                             'b.strPackageStatus',
                             'b.intPackageDuration',
                             'c.dblPackagePrice',
                             'b.intPackagePax',
                             'b.strPackageDescription',
                             'b.intBoatFee')
                    ->where('c.dtmPackagePriceAsOf',"=", DB::raw("(SELECT MAX(dtmPackagePriceAsOf) FROM tblPackagePrice WHERE strPackageID = b.strPackageID)"))
                    ->where(function($query){
                        $query->where('b.strPackageStatus', '=', 'Available')
                              ->orWhere('b.strPackageStatus', '=', "Unavailable");
                    })
                    ->where('a.strAvailPReservationID', '=', $id)
                    ->get();

        $PackageID = $PackageInfo->pluck('strPackageID')->first();
        
        $ReservationInfo = $this->getReservationInfo($id);

        $ChosenRooms = $this->getReservedRooms($id);

        $PackageRoomInfo = DB::table('tblRoomType as a')
                        ->join('tblPackageRoom as b', 'a.strRoomTypeID', '=', 'b.strPackageRRoomTypeID')
                        ->select('a.strRoomType',
                                 'b.intPackageRQuantity',
                                 'b.strPackageRPackageID')
                        ->where('b.strPackageRPackageID', '=', $PackageID)
                        ->groupBy('b.strPackageRPackageID', 'a.strRoomType', 'b.intPackageRQuantity')
                        ->get();
        
        
        $PackageActivityInfo = DB::table('tblBeachActivity as a')
                        ->join('tblPackageActivity as b', 'a.strBeachActivityID', '=', 'b.strPackageABeachActivityID')
                        ->select('a.strBeachAName',
                                 'b.intPackageAQuantity',
                                 'b.strPackageAPackageID')
                        ->where('b.strPackageAPackageID', '=', $PackageID)
                        ->groupBy('b.strPackageAPackageID', 'a.strBeachAName', 'b.intPackageAQuantity')
                        ->get();
        
        $PackageItemInfo = DB::table('tblPackageItem as a')
                        ->join('tblItem as b', 'a.strPackageIItemID', '=', 'b.strItemID')
                        ->select('b.strItemName',
                                 'a.intPackageIQuantity',
                                 'a.flPackageIDuration',
                                 'a.strPackageIPackageID')
                        ->where('a.strPackageIPackageID', '=', $PackageID)
                        ->groupBy('a.strPackageIPackageID', 'b.strItemName', 'a.intPackageIQuantity', 'a.flPackageIDuration')
                        ->get();
        
        $PackageFeeInfo = DB::table('tblFee as a')
                        ->join('tblPackageFee as b', 'a.strFeeID', '=', 'b.strPackageFFeeID')
                        ->join('tblFeeAmount as c', 'a.strFeeID', '=', 'c.strFeeID')
                        ->select('a.strFeeName',
                                 'c.dblFeeAmount',
                                 'b.strPackageFPackageID')
                        ->where([['c.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")],['b.strPackageFPackageID', '=', $PackageID]])
                        ->get();

        return view('Reservation', compact('ReservationInfo', 'ChosenRooms', 'PackageInfo', 'PackageRoomInfo', 'PackageActivityInfo', 'PackageItemInfo', 'PackageFeeInfo'));
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

    public function getReservationInfo($ReservationID){
        
        $ReservationInfo = DB::table('tblReservationDetail as a')
                        ->join ('tblCustomer as b', 'a.strResDCustomerID', '=' , 'b.strCustomerID')
                        ->select('a.strReservationID',
                                 DB::raw('CONCAT(b.strCustFirstName , " " , b.strCustMiddleName , " " , b.strCustLastName) AS Name'),
                                 'a.dteResDBooking',
                                 DB::raw('DATE_ADD(a.dteResDBooking, INTERVAL 7 DAY) AS PaymentDueDate'),
                                 'a.intResDNoOfAdults',
                                 'a.intResDNoOfKids',
                                 'a.strResDRemarks',
                                 'a.dtmResDArrival',
                                 'a.dtmResDDeparture',
                                 'b.strCustContact',
                                 'b.strCustEmail',
                                 'b.strCustAddress',
                                 'b.dtmCustBirthday',
                                 'b.strCustNationality',
                                 'b.strCustGender',
                                 'a.strReservationCode',
                                 'a.strResDDepositSlip')
                        ->where('strReservationID', '=', $ReservationID)
                        ->get();
        
        foreach($ReservationInfo as $Info){
            $Info->PaymentDueDate = Carbon::parse($Info->PaymentDueDate)->format('M j, Y');
            $Info->dteResDBooking = Carbon::parse($Info->dteResDBooking)->format('M j, Y');

        }
        
        return $ReservationInfo;
    }
}
