<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class ViewController extends Controller
{
    //Maintenance
    
    public function ViewRoomTypes(){
        $RoomTypes = DB::table('tblRoomType as a')
            ->join ('tblRoomRate as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
            ->select('a.strRoomTypeID', 
                     'a.strRoomType', 
                     'a.intRoomTCapacity', 
                     'a.intRoomTNoOfBeds', 
                     'a.intRoomTNoOfBathrooms', 
                     'a.intRoomTAirconditioned',
                     'a.intRoomTCategory',
                     'b.dblRoomRate', 
                     'a.strRoomDescription')
            ->where([['b.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],
                    ['a.intRoomTDeleted',"=", "1"]
                    ,['a.intRoomTCategory',"=", "1"]])
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
        }
        
        $CottageTypes = DB::table('tblRoomType as a')
            ->join ('tblRoomRate as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
            ->select('a.strRoomTypeID', 
                     'a.strRoomType', 
                     'a.intRoomTCapacity', 
                     'a.intRoomTNoOfBeds', 
                     'a.intRoomTNoOfBathrooms', 
                     'a.intRoomTAirconditioned',
                     'a.intRoomTCategory',
                     'b.dblRoomRate', 
                     'a.strRoomDescription')
            ->where([['b.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],
                    ['a.intRoomTDeleted',"=", "1"]
                    ,['a.intRoomTCategory',"=", "0"]])
            ->get();
        
        foreach ($CottageTypes as $Cottage) {
            if($Cottage->intRoomTCategory == '1'){
                $Cottage->intRoomTCategory = 'Room';
            }
            else{
                $Cottage->intRoomTCategory = 'Cottage';
            }
        }
        
        if((sizeof($RoomTypes) == 0) && (sizeof($CottageTypes) == 0)){
            $RoomTypeID = "ACMT1";
        }
        else{
            $RoomTypeID = $this->SmartCounter('tblRoomType', 'strRoomTypeID');
        }
        
        return view('Maintenance.RoomTypeMaintenance', compact('RoomTypes', 'RoomTypeID', 'CottageTypes'));
    }
      
    public function ViewRooms(){
        $Rooms = DB::table('tblRoom as a')
            ->join ('tblRoomType as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
            ->select('a.strRoomID',
                    'b.strRoomType',
                    'a.strRoomName',
                    'a.strRoomStatus')
            ->where([['a.strRoomStatus', '!=', 'deleted'],['b.intRoomTCategory', '=', '1']])
            ->orderBy('a.tmsCreated', 'desc')
            ->get();
        
        $Cottages = DB::table('tblRoom as a')
            ->join ('tblRoomType as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
            ->select('a.strRoomID',
                    'b.strRoomType',
                    'a.strRoomName',
                    'a.strRoomStatus')
            ->where([['a.strRoomStatus', '!=', 'deleted'],['b.intRoomTCategory', '=', '0']])
            ->orderBy('a.tmsCreated', 'desc')
            ->get();
    
        if((sizeof($Rooms) == 0) && (sizeof($Cottages) == 0)){
            $RoomID = "RMCT1";
        }
        else{
            $RoomID = $this->SmartCounter('tblRoom', 'strRoomID');
        }
    
        return view('Maintenance.RoomMaintenance', compact('Rooms', 'RoomID', 'Cottages'));
    }
    
    public function ViewBoats(){
        $Boats = DB::table('tblBoat as a')
                ->join ('tblBoatRate as b', 'a.strBoatID', '=' , 'b.strBoatID')
                ->select('a.strBoatID', 
                         'a.strBoatName',
                         'a.intBoatCapacity',
                         'b.dblBoatRate',
                         'a.strBoatStatus',
                         'a.strBoatDescription')
                ->where('b.dtmBoatRateAsOf',"=", DB::raw("(SELECT max(dtmBoatRateAsOf) FROM tblBoatRate WHERE strBoatID = a.strBoatID)"))
                ->where(function($query){
                    $query->where('a.strBoatStatus', '=', 'Available')
                          ->orWhere('a.strBoatStatus', '=', "Unavailable");
                })
                ->get();   
        
        if(sizeof($Boats) != 0){
            $BoatID = $this->SmartCounter('tblBoat', 'strBoatID');
        }
        else{
            $BoatID = "BOAT1";
        }

        return view('Maintenance.BoatMaintenance', compact('Boats', 'BoatID'));
    }
    
    public function ViewItems(){
        $Items = DB::table('tblItem as a')
                ->join ('tblItemRate as b', 'a.strItemID', '=' , 'b.strItemID')
                ->select('a.strItemID',
                         'a.strItemName',
                         'a.intItemQuantity',
                         'b.dblItemRate',
                         'a.strItemDescription')
                ->where([['b.dtmItemRateAsOf',"=", DB::raw("(SELECT max(dtmItemRateAsOf) FROM tblItemRate WHERE strItemID = a.strItemID)")],
                        ['a.intItemDeleted',"=", "1"]])
                ->get();   
        
        if(sizeof($Items) != 0){
            $ItemID = $this->SmartCounter('tblItem', 'strItemID');
        }
        else{
            $ItemID = "ITEM1";
        }
        
        return view('Maintenance.ItemMaintenance', compact('Items', 'ItemID'));
    }
    
    public function ViewActivities(){
        $Activities = DB::table('tblBeachActivity as a')
                ->join ('tblBeachActivityRate as b', 'a.strBeachActivityID', '=' , 'b.strBeachActivityID')
                ->select('a.strBeachActivityID',
                         'a.strBeachAName',
                         'a.strBeachAStatus',
                         'b.dblBeachARate',
                         'a.intBeachABoat',
                         'a.strBeachADescription')
                ->where('b.dtmBeachARateAsOf',"=", DB::raw("(SELECT max(dtmBeachARateAsOf) FROM tblBeachActivityRate WHERE strBeachActivityID = a.strBeachActivityID)"))
                ->where(function($query){
                    $query->where('a.strBeachAStatus', '=', 'Available')
                          ->orWhere('a.strBeachAStatus', '=', "Unavailable");
                })
                ->get();

        foreach ($Activities as $Activity) {

            if($Activity->intBeachABoat == '1'){
                $Activity->intBeachABoat = 'Yes';
            }
            else{
                $Activity->intBeachABoat = 'No';
            }

        }
        
        if(sizeof($Activities) != 0){
            $ActivityID = $this->SmartCounter('tblBeachActivity', 'strBeachActivityID');
        }
        else{
            $ActivityID = "ACTV1";
        }
    

        return view('Maintenance.ActivityMaintenance', compact('Activities', 'ActivityID'));
    }
    
    public function ViewWebsite(){
        return view('Maintenance.WebsiteMaintenance');
    }
    
    public function ViewOperations(){
        $Dates = DB::table('tblInoperationalDate')
                ->where('intDateStatus','!=','0')
                ->get();

        foreach ($Dates as $Date) {
            if($Date->intDateStatus == '1'){
                $Date->intDateStatus = 'Active';
            }
            else{
                $Date->intDateStatus= 'Inactive';
            }
        }
        
        if(sizeof($Dates) != 0){
            $DateID = $this->SmartCounter('tblInoperationalDate', 'strDateID');
        }
        else{
            $DateID = "DATE1";
        }
        
        return view('Maintenance.OperationsMaintenance', compact('Dates', 'DateID'));
    }
        
    public function ViewPackages(){
        $Packages = $this->getPackages();
        return view('Maintenance.PackageMaintenance', compact('Packages'));
    }
    
    public function ViewBoatPersonnel(){
        return view('Maintenance.BoatPersonnel');
    }
    
    public function ViewFees(){
        $Fees = DB::table('tblFee as a')
                ->join ('tblFeeAmount as b', 'a.strFeeID', '=' , 'b.strFeeID')
                ->select('a.strFeeID',
                         'a.strFeeName',
                         'a.strFeeStatus',
                         'b.dblFeeAmount',
                         'a.strFeeDescription')
                ->where([['b.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")],['a.strFeeStatus', '!=', 'deleted']])
                ->get();
        
        if(sizeof($Fees) != 0){
            $FeeID = $this->SmartCounter('tblFee', 'strFeeID');
        }
        else{
            $FeeID = "FEE1";
        }
        
        return view('Maintenance.FeeMaintenance', compact('Fees', 'FeeID'));
    }
    
    
    //Maintenance AJAX
    
    //get Room Types
    
    public function getRoomTypes(){
        $RoomTypes = DB::table('tblRoomType')->where([['intRoomTDeleted', '1'],['intRoomTCategory', '1']])->orderBy('strRoomType')->pluck('strRoomType');
        
        return response()->json($RoomTypes);
    }
    
    //get Cottage Types
    public function getCottageTypes(){
       $CottageTypes = DB::table('tblRoomType')->where([['intRoomTDeleted', '1'],['intRoomTCategory', '0']])->orderBy('strRoomType')->pluck('strRoomType');
        
        return response()->json($CottageTypes);
    }
    
    //get Room Image
    public function getRoomImage(Request $req){
        $RoomTypeID = trim($req->input('RoomTypeID'));
        
        $RoomImages = DB::table('tblRoomPicture')
                    ->where('strRoomPRoomTID', '=', $RoomTypeID)
                    ->get();
        
        return response()->json($RoomImages);
    }
    
    
    //Package
    
    public function ViewAddPackage(){
        $Items = DB::table('tblItem')->where('intItemDeleted', '1')->pluck('strItemName');
        $Activities = DB::table('tblBeachActivity')->where('strBeachAStatus', '=', 'Available')->pluck('strBeachAName');
        $Fees = DB::table('tblFee')->where('strFeeStatus', '=', 'Active')->pluck('strFeeName');
        
        $Packages = $this->getPackages();
        if(sizeof($Packages) != 0){
            $PackageID = $this->SmartCounter('tblPackage', 'strPackageID');
        }
        else{
            $PackageID = "PACK1";
        }
        
        return view('Maintenance.AddPackage', compact('Items', 'Activities', 'Fees', 'PackageID'));
    }
    
    public function ViewEditPackage($id){
        
        $PackageInfo = DB::table('tblPackage as a')
                ->join ('tblPackagePrice as b', 'a.strPackageID', '=' , 'b.strPackageID')
                ->select('a.strPackageID',
                         'a.strPackageName',
                         'a.strPackageStatus',
                         'a.intPackageDuration',
                         'b.dblPackagePrice',
                         'a.intPackagePax',
                         'a.strPackageDescription',
                         'a.intBoatFee')
                ->where([['b.dtmPackagePriceAsOf',"=", DB::raw("(SELECT MAX(dtmPackagePriceAsOf) FROM tblPackagePrice WHERE strPackageID = a.strPackageID)")],['a.strPackageID',"=", $id]])
                ->get();
        
        $PackageItemInfo = $this->getItemInclusion($id);
        $PackageRoomInfo = $this->getRoomInclusion($id);
        $PackageActivityInfo = $this->getActivityInclusion($id);
        $PackageFeeInfo = $this->getFeeInclusion($id);
        
        $RoomTypes = DB::table('tblRoomType')->where('intRoomTDeleted', '1')->pluck('strRoomType');
        $Items = DB::table('tblItem')->where('intItemDeleted', '1')->pluck('strItemName');
        $Activities = DB::table('tblBeachActivity')->where('strBeachAStatus', '=', 'Available')->pluck('strBeachAName');
        $Fees = DB::table('tblFee')->where('strFeeStatus', '=', 'Active')->pluck('strFeeName');
        
        return view('Maintenance.EditPackage', compact('PackageInfo', 'PackageItemInfo', 'PackageRoomInfo', 'PackageActivityInfo', 'PackageFeeInfo', 'RoomTypes', 'Items', 'Activities', 'Fees'));
    }
    
    public function ViewPackageRooms(Request $req){
        $PackageDuration = trim($req->input('PackageDuration'));
        if($PackageDuration == 1){
           $RoomTypes = DB::table('tblRoomType')->where('intRoomTDeleted', '1')->pluck('strRoomType'); 
        }
        else{
           $RoomTypes = DB::table('tblRoomType')->where([['intRoomTDeleted', '1'], ['intRoomTCategory', '1']])->pluck('strRoomType'); 
        }
        return response()->json($RoomTypes);
    }
    
    // get Package Inclusion
    
    public function getPackageInclusion(Request $req){
        $PackageID = trim($req->input('id'));
        
        $PackageItemInfo = $this->getItemInclusion($PackageID);
        $PackageRoomInfo = $this->getRoomInclusion($PackageID);
        $PackageActivityInfo = $this->getActivityInclusion($PackageID);
        $PackageFeeInfo = $this->getFeeInclusion($PackageID);

        return response()->json(['PackageItemInfo' => $PackageItemInfo, 'PackageRoomInfo' => $PackageRoomInfo, 'PackageActivityInfo' => $PackageActivityInfo, 'PackageFeeInfo' => $PackageFeeInfo]);
    }
    
    public function getItemInclusion($PackageID){
        $PackageItemInfo = DB::table('tblPackageItem as a')
                        ->join('tblItem as b', 'a.strPackageIItemID', '=', 'b.strItemID')
                        ->join('tblItemRate as c', 'b.strItemID', '=', 'c.strItemID')
                        ->select('b.strItemName',
                                 'a.intPackageIQuantity',
                                 'a.flPackageIDuration',
                                 DB::raw('((c.dblItemRate * a.intPackageIQuantity) * a.flPackageIDuration) as ItemProduct'))
                        ->where([['a.strPackageIPackageID', '=', $PackageID], ['c.dtmItemRateAsOf',"=", DB::raw("(SELECT max(dtmItemRateAsOf) FROM tblItemRate WHERE strItemID = b.strItemID)")]])
                        ->get();
        
        return $PackageItemInfo;
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
    
    public function getActivityInclusion($PackageID){
        $PackageActivityInfo = DB::table('tblBeachActivity as a')
                        ->join('tblPackageActivity as b', 'a.strBeachActivityID', '=', 'b.strPackageABeachActivityID')
                        ->join('tblBeachActivityRate as c', 'a.strBeachActivityID', '=', 'c.strBeachActivityID')
                        ->select('a.strBeachAName',
                                 'b.intPackageAQuantity',
                                 DB::raw('(c.dblBeachARate * b.intPackageAQuantity) as ActivityProduct'))
                        ->where([['b.strPackageAPackageID', '=', $PackageID], ['c.dtmBeachARateAsOf',"=", DB::raw("(SELECT max(dtmBeachARateAsOf) FROM tblBeachActivityRate WHERE strBeachActivityID = a.strBeachActivityID)")]])
                        ->get();
        
        return $PackageActivityInfo;
    }
    
    public function getFeeInclusion($PackageID){
        $PackageFeeInfo = DB::table('tblFee as a')
                        ->join('tblPackageFee as b', 'a.strFeeID', '=', 'b.strPackageFFeeID')
                        ->join('tblFeeAmount as c', 'a.strFeeID', '=', 'c.strFeeID')
                        ->select('a.strFeeName',
                                 'c.dblFeeAmount')
                        ->where([['b.strPackageFPackageID', '=', $PackageID], ['c.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")]])
                        ->get();
        
        return $PackageFeeInfo;
    }
    
    
    // get Room Details

    public function ViewRoomTypeDetails(Request $req) {
        $RoomType = trim($req->input('id'));
         
        $RoomTypeID = DB::table('tblRoomType')->where([['strRoomType',"=",$RoomType], ['intRoomTDeleted',"=","1"]])->pluck('strRoomTypeID')->first();
        
        $RoomInfo = DB::table('tblRoomType as a')
            ->join ('tblRoomRate as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
            ->select('a.strRoomTypeID', 
                     'a.strRoomType', 
                     'a.intRoomTCapacity',
                     'a.intRoomTCategory',
                     'a.intRoomTNoOfBeds', 
                     'a.intRoomTNoOfBathrooms', 
                     'a.intRoomTAirconditioned', 
                     'b.dblRoomRate', 
                     'a.strRoomDescription',
                     'a.intRoomTCategory')
            ->where([['b.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],
                    ['a.intRoomTDeleted',"=", "1"], ['a.strRoomTypeID', "=", $RoomTypeID]])
            ->get();
        
        
        foreach ($RoomInfo as $Room) {

            if($Room->intRoomTAirconditioned == '1'){
                $Room->intRoomTAirconditioned = 'Yes';
            }
            else{
                $Room->intRoomTAirconditioned = 'No';
            }
            
            if($Room->intRoomTCategory == '1'){
                $Room->intRoomTCategory = "Room";
            } 
            else{
                $Room->intRoomTCategory = "Cottage";
            }

        }
        
        $TotalRooms = DB::table('tblRoomType as b')
            ->join ('tblRoom as a', 'b.strRoomTypeID', '=' , 'a.strRoomTypeID')
            ->select('a.strRoomTypeID')
            ->where([['b.strRoomType',"=", $RoomType], ['a.strRoomStatus', "=", 'Available']])
            ->count();
   
        $RoomInfo->put('TotalRooms', $TotalRooms);
        
        return response()->json($RoomInfo);
     }
    
    // get Item Details
    
    public function ViewItemDetails(Request $req){
        $ItemName = trim($req->input('id'));
         
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
    
    // get Activity Details
    
    public function ViewActivityDetails(Request $req){
        $ActivityName = trim($req->input('id'));
         
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
    
    // get Fee Details
    
    public function ViewFeeDetails(Request $req){
        $FeeName = trim($req->input('id'));
         
        $FeeID = DB::table('tblFee')->where([['strFeeName','=',$FeeName], ['strFeeStatus','=',"Active"]])->pluck('strFeeID')->first();
        
        $FeeInfo = DB::table('tblFee as a')
                ->join ('tblFeeAmount as b', 'a.strFeeID', '=' , 'b.strFeeID')
                ->select('a.strFeeID',
                         'a.strFeeName',
                         'b.dblFeeAmount',
                         'a.strFeeDescription')
                ->where([['b.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")],['a.strFeeStatus', '!=', 'deleted'], ['a.strFeeID', '=', $FeeID]])
                ->get();
        
        return response()->json($FeeInfo);
    }
    
    
    public function TotalRoomCapacity(){
        $RoomTypes = DB::table('tblRoomType')
            ->select('strRoomTypeID', 
                     'strRoomType', 
                     'intRoomTCapacity')
            ->where('intRoomTDeleted',"=", "1")
            ->get();
        
        return response()->json($RoomTypes);
        
    }
    
    
    
    //SmartCounter
    
    public function SmartCounter($strTableName, $strColumnName){
        $endLoop = false;
        $latestID = DB::table($strTableName)->where('tmsCreated', DB::raw("(SELECT max(tmsCreated) FROM ".$strTableName.")"))->pluck($strColumnName)->first();
        
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
    
    
    //MISC
    
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
    
    
    
    
    /*------END OF MAINTENANCE------*/
    
    
    
    
     //Reservation
    
    public function getAvailablePackages(Request $req){
        $CheckInDate = trim($req->input('CheckInDate'));
        $Packages = $this->getPackages();
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
    
    public function ViewReservations(){
        $Reservations = DB::table('tblReservationDetail as a')
                        ->join ('tblCustomer as b', 'a.strResDCustomerID', '=' , 'b.strCustomerID')
                        ->select('a.strReservationID',
                                 DB::raw('CONCAT(b.strCustFirstName , " " , b.strCustLastName) AS Name'),
                                 'a.dteResDBooking',
                                 DB::raw('DATE_ADD(a.dteResDBooking, INTERVAL 7 DAY) AS PaymentDueDate'),
                                 'a.dtmResDArrival',
                                 'a.dtmResDDeparture',
                                 'b.strCustContact',
                                 'b.strCustEmail',
                                 'a.strReservationCode')
                        ->where([['a.intResDStatus', '=', '1'], ['a.intWalkIn', '=', '0']])
                        ->get();
        
        $DateToday = Carbon::now()->toDateString();

        foreach ($Reservations as $Reservation){
            $tempPaymentDueDate = explode(' ', $Reservation->PaymentDueDate);
            $Reservation->PaymentDueDate = $tempPaymentDueDate[0];
            
            if(!($Reservation->PaymentDueDate >= $DateToday)){
                $this->CancelReservation($Reservation->strReservationID);
            }
            
        }
        
       $FloatingReservations = DB::table('tblReservationDetail as a')
                    ->join ('tblCustomer as b', 'a.strResDCustomerID', '=' , 'b.strCustomerID')
                    ->select('a.strReservationID',
                             DB::raw('CONCAT(b.strCustFirstName , " " , b.strCustLastName) AS Name'),
                             'a.dteResDBooking',
                             DB::raw('DATE_ADD(a.dteResDBooking, INTERVAL 7 DAY) AS PaymentDueDate'),
                             'a.dtmResDArrival',
                             'a.dtmResDDeparture',
                             'b.strCustContact',
                             'b.strCustEmail',
                             'a.strReservationCode')
                    ->where([['a.intResDStatus', '=', '1'], ['a.intWalkIn', '=', '0']])
                    ->get();
        
        $PaidReservations = DB::table('tblReservationDetail as a')
                    ->join ('tblCustomer as b', 'a.strResDCustomerID', '=' , 'b.strCustomerID')
                    ->join ('tblPayment as c', 'a.strReservationID', '=', 'c.strPayReservationID')
                    ->select('a.strReservationID',
                             DB::raw('CONCAT(b.strCustFirstName , " " , b.strCustLastName) AS Name'),
                             'a.dtmResDArrival',
                             'a.dtmResDDeparture',
                             'b.strCustContact',
                             'b.strCustEmail',
                             'a.strReservationCode',
                             'c.dblPayAmount')
                    ->where([['a.intResDStatus', '=', '2'], ['a.intWalkIn', '=', '0'], ['c.strPayTypeID', '=', 1]])
                    ->get();
        
        foreach($PaidReservations as $Paid){
            $DownPayment = DB::table('tblPayment')->where([['strPayReservationID', '=', $Paid->strReservationID], ['strPayTypeID', '=', 2]])->pluck('dblPayAmount')->first();
            
            $Paid->dblPayAmount = $Paid->dblPayAmount - $DownPayment;
        }
        
        return view('Reservations', compact('FloatingReservations', 'PaidReservations'));
    }
    
    public function ViewBookReservations(){
        $Dates = DB::table('tblInoperationalDate')
                ->where('intDateStatus','=','1')
                ->get();
        
        
        return View('BookReservations', compact('Dates'));
    }
    
    public function CancelReservation($ReservationID){
        
        $updateData = array("intResDStatus" => "3");   
        
        DB::table('tblReservationDetail')
            ->where('strReservationID', $ReservationID)
            ->update($updateData);
        
        $ChosenBoats = DB::table('tblReservationBoat')->where('strResBReservationID', "=", $ReservationID)->pluck('strResBBoatID');
        if(count($ChosenBoats) != 0){
            $updateBoatData = array("intBoatSStatus" => "0");
            DB::table('tblBoatSchedule')
                ->where('strBoatSReservationID', $ReservationID)
                ->update($updateBoatData);
        }
    }
    
    public function ViewReservationPackages(){
        //$Packages = $this->getPackages();
        return view('BookWithPackage');
    }
    
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
            ->whereNotIn('a.strBoatID', [DB::raw("(SELECT strBoatSBoatID FROM tblBoatSchedule WHERE intBoatSStatus = 1 AND (date(dtmBoatSPickUp) = '".$ArrivalDate."') AND '".$PickUpTime."' BETWEEN time(dtmBoatSPickUp) AND time(DATE_ADD(dtmBoatSPickUp, INTERVAL 1 HOUR)))")])
            ->where([['a.strBoatStatus', "=", 'Available'], ['b.dtmBoatRateAsOf',"=", DB::raw("(SELECT max(dtmBoatRateAsOf) FROM tblBoatRate WHERE strBoatID = a.strBoatID)")]])
            ->orderBy('a.intBoatCapacity')
            ->get();
        
        return response()->json($BoatsAvailable);
    }
    
    public function getReservationFees(){
        $Fees = DB::table('tblFee as a')
                ->join ('tblFeeAmount as b', 'a.strFeeID', '=' , 'b.strFeeID')
                ->select('a.strFeeName',
                         'b.dblFeeAmount')
                ->where([['b.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")],['a.strFeeStatus', '=', 'Active'],['a.strFeeName', '=', 'Entrance Fee']])
                ->get();
        
        return response()->json($Fees);
    }
    
    public function getReservationInfo(Request $req){
        
        $ReservationID = trim($req->input('id'));

        $ReservationInfo = $this->getReservation($ReservationID);
        $ReservationPackage = $this->getReservationPackage($ReservationID);
        $ChosenRooms = $this->getReservedRooms($ReservationID);
        $ChosenBoats = $this->getReservedBoats($ReservationID);
        $InitialBill = $this->getInitialBill($ReservationID);
     
        return response()->json(['ReservationInfo' => $ReservationInfo, 'ChosenRooms' => $ChosenRooms, 'ChosenBoats' => $ChosenBoats, 'InitialBill' => $InitialBill, 'ReservationPackage' => $ReservationPackage]);
    }
    
    
    public function getReservation($ReservationID){
        
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
                                 'a.strReservationCode')
                        ->where('strReservationID', '=', $ReservationID)
                        ->get();
        
        foreach($ReservationInfo as $Info){
            $Info->PaymentDueDate = Carbon::parse($Info->PaymentDueDate)->format('M j, Y');
            $Info->dteResDBooking = Carbon::parse($Info->dteResDBooking)->format('M j, Y');

        }
        
        return $ReservationInfo;
    }
    
    public function getReservationPackage($ReservationID){
        
        $ReservationPackage = DB::table('tblAvailPackage as a')
                        ->join ('tblPackage as b', 'b.strPackageID','=' ,'a.strAvailPackageID')
                        ->select('b.strPackageName')
                        ->where('a.strAvailPReservationID', '=', $ReservationID)
                        ->get();
        
        return $ReservationPackage;
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
    
    public function getReservedBoats($ReservationID){
        $ChosenBoats = DB::table('tblReservationBoat as a')
                            ->join ('tblBoat as b', 'a.strResBBoatID', '=' , 'b.strBoatID')
                            ->select('b.strBoatID',
                                     'b.strBoatName',
                                     'b.intBoatCapacity')
                            ->where('strResBReservationID', "=", $ReservationID)
                            ->get();
        
        return $ChosenBoats;
    }
    
    public function getInitialBill($ReservationID){
        $InitialBill = DB::table('tblPayment')
                            ->select('dblPayAmount')
                            ->where([['strPayReservationID', "=", $ReservationID], ['strPayTypeID', '=', '1']])
                            ->get();
        
        return $InitialBill;
    }
    
    public function ViewEditReservation($id){
        
        $ReservationInfo = $this->getReservation($id);
        $ChosenRooms = $this->getReservedRooms($id);
        $PickUpTime = "";
        $ArrivalDate = "";
        $DepartureDate = "";
        foreach($ReservationInfo as $Reservation){
            $arrArrivalDate = explode(" ", $Reservation->dtmResDArrival);
            $arrDepartureDate = explode(" ", $Reservation->dtmResDDeparture);
            $ArrivalDate = $arrArrivalDate[0];
            $DepartureDate = $arrDepartureDate[0];
            $arrPickUpTime = explode(":", $arrArrivalDate[1]);
            if((int)$arrPickUpTime[0] > 12){
                $arrPickUpTime[0] = (int)$arrPickUpTime[0] - 12;
                $PickUpTime = $arrPickUpTime[0] .":". $arrPickUpTime[1] .":". $arrPickUpTime[2] ." PM";
            }
            else{
                $PickUpTime = $arrArrivalDate[1] ." AM"; 
            }
        }
        
        $Rooms = $this->fnGetAvailableRooms($ArrivalDate, $DepartureDate);
        
        return view('EditReservations', compact('ReservationInfo', 'ChosenRooms' , 'PickUpTime', 'Rooms'));
    }
    
    public function getEditAvailableBoats(Request $req){
        $tempArrivalDate = trim($req->input('CheckInDate'));
        $DepartureDate = trim($req->input('CheckOutDate'));
        $PickUpTime = trim($req->input('PickUpTime'));
        $TotalGuests = trim($req->input('TotalGuests'));
        $ReservationID = trim($req->input('ReservationID'));
        
        $tempArrivalDate2 = explode('/', $tempArrivalDate);

        $ArrivalDate = $tempArrivalDate2[2] ."/". $tempArrivalDate2[0] ."/". $tempArrivalDate2[1];
     
        $BoatsAvailable = $this->getReschedAvailBoats($ReservationID, $ArrivalDate, $PickUpTime);
        
        return response()->json($BoatsAvailable);
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
    
    public function checkReservedRoomBoat(Request $req){
        $ReservationID = trim($req->input('id'));
        $tempArrivalDate = trim($req->input('CheckInDate'));
        $tempCheckOutDate = trim($req->input('CheckOutDate'));
        $PickUpTime = trim($req->input('PickUpTime'));
        $TotalGuests = trim($req->input('TotalGuests'));  
        $PickOutTime;
        
        if($tempArrivalDate == $tempCheckOutDate){
            $PickOutTime = "23:59:59";
        }
        else{
            $PickOutTime = $PickUpTime;
        }
        $errorBoat = false;
        $errorRoom = false;
 
        $ChosenBoats = $this->getReservedBoats($ReservationID);
        $ChosenRooms = $this->getReservedRooms($ReservationID);

        $tempArrivalDate2 = explode('/', $tempArrivalDate);

        $ArrivalDate = $tempArrivalDate2[2] ."/". $tempArrivalDate2[0] ."/". $tempArrivalDate2[1] ." ". $PickUpTime;
        
        $tempCheckOutDate2 = explode('/', $tempCheckOutDate);

        $DepartureDate = $tempCheckOutDate2[2] ."/". $tempCheckOutDate2[0] ."/". $tempCheckOutDate2[1] ." ". $PickOutTime;
        
        if($ChosenBoats != null){
            $tempArrivalDate2 = explode('/', $tempArrivalDate);

            $ArrivalDate = $tempArrivalDate2[2] ."/". $tempArrivalDate2[0] ."/". $tempArrivalDate2[1];

            $BoatsAvailable = $this->getReschedAvailBoats($ReservationID, $ArrivalDate, $PickUpTime);
            $TotalBoats = count($ChosenBoats);
            $BoatCounter = 0;
            foreach($ChosenBoats as $ChosenBoat){
                foreach($BoatsAvailable as $AvailableBoat){
                    if($ChosenBoat->strBoatID == $AvailableBoat->strBoatID){
                        $BoatCounter++;
                    }
                }
            }
            
            if($BoatCounter != $TotalBoats){
                $errorBoat = true;
            }
        }
        
        
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

        $Rooms = DB::table('tblRoom as a')
                    ->join ('tblRoomType as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
                    ->join ('tblRoomRate as c', 'a.strRoomTypeID', '=' , 'c.strRoomTypeID')
                    ->select('a.strRoomTypeID',
                             'b.strRoomType',
                             'c.dblRoomRate',
                              DB::raw("COUNT(a.strRoomTypeID) as TotalRooms"))
                     ->whereNotIn('strRoomID', $ExistingRooms)
                     ->where([['a.strRoomStatus','=','Available'],['c.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")]])
                     ->groupBy('a.strRoomTypeID', 'b.strRoomType', 'c.dblRoomRate', 'b.intRoomTCapacity')
                     ->get();

      
        $RoomCounter = 0;
        $TotalChosenRooms = count($ChosenRooms);
        
        foreach($ChosenRooms as $ChosenRoom){
            foreach($Rooms as $Room){
                if($ChosenRoom->strRoomTypeID == $Room->strRoomTypeID){
                    if((int)$ChosenRoom->TotalRooms <= (int)$Room->TotalRooms){
                        $RoomCounter++;
                    }
                }
            }
        }
        
        if($RoomCounter != $TotalChosenRooms){
            $errorRoom = true;
        }
        
        return response()->json(['ChosenBoats' => $ChosenBoats, 'errorBoat' => $errorBoat, 'errorRoom' => $errorRoom]);
    }

    public function getReschedAvailBoats($ReservationID, $ArrivalDate, $PickUpTime){
        $BoatsAvailable = DB::table('tblBoat as a')
             ->join ('tblBoatRate as b', 'a.strBoatID', '=' , 'b.strBoatID')
                ->select('a.strBoatID', 
                         'a.strBoatName',
                         'a.intBoatCapacity',
                         'b.dblBoatRate',
                         'a.strBoatStatus',
                         'a.strBoatDescription')
                ->whereNotIn('a.strBoatID', [DB::raw("(SELECT strBoatSBoatID FROM tblBoatSchedule WHERE intBoatSStatus = 1 AND NOT strBoatSReservationID = '".$ReservationID."' AND (date(dtmBoatSPickUp) = '".$ArrivalDate."') AND '".$PickUpTime."' BETWEEN time(dtmBoatSPickUp) AND time(DATE_ADD(dtmBoatSPickUp, INTERVAL 1 HOUR)))")])
                ->where([['a.strBoatStatus', "=", 'Available'], ['b.dtmBoatRateAsOf',"=", DB::raw("(SELECT max(dtmBoatRateAsOf) FROM tblBoatRate WHERE strBoatID = a.strBoatID)")]])
                ->orderBy('a.intBoatCapacity')
                ->get();
        
        return $BoatsAvailable;
        
    }
    
    /* ------------- END OF RESERVATION ------------- */
    
    

    
   
    
    
    
    
}
