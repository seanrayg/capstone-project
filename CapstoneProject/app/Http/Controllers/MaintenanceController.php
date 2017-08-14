<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
 
class MaintenanceController extends Controller
{
    
    
    //ROOM TYPE FUNCTIONS 
    
    
    //Add Room Type
    
    public function storeRoomType(Request $req){
        $UserInput = Input::all();
           $rules =  [
                'RoomTypeCode' => 'unique:tblRoomType,strRoomTypeID',
           ];
        
            $validator = Validator::make($UserInput, $rules);

            if ($validator->fails()) {
                \Session::flash('duplicate_message','Accomodation ID is already taken. Please enter a new one to continue.');
                    return redirect('Maintenance/RoomType')->withInput();
            }
            else{
                $tempRoomTypeName = trim($req->input('RoomTypeName'));
                $RoomNameError = DB::table('tblRoomType')->where([['intRoomTDeleted', '1'],['strRoomType', $tempRoomTypeName]])->first();
                
                if($RoomNameError){
                    
                    \Session::flash('duplicate_message','Name is already taken. Please enter a new one to continue.');
                    return redirect('Maintenance/RoomType')->withInput();
                }
                
                else{
                    $RoomTypeCode = trim($req->input('RoomTypeCode'));
                    $RoomTypeName = trim($req->input('RoomTypeName'));
                    $RoomCapacity = trim($req->input('RoomCapacity'));
                    $NoOfBeds = trim($req->input('NoOfBeds'));
                    $NoOfBathrooms = trim($req->input('NoOfBathrooms'));
                    $RoomDescription;
                    $intRoomTAirconditioned;
                    $intRoomTCategory;
                    $RoomAircondition = $req->input('RoomAirconditioned');
                    $RoomCategory = $req->input('RoomCategory');
                    $DateCreated = Carbon::now();
                    $RoomRate = trim($req->input('RoomRate'));


                    if(!empty(trim($req->input('RoomDescription')))){
                        $RoomDescription = trim($req->input('RoomDescription'));
                    }
                    else{
                        $RoomDescription = "N/A";
                    }

                    if($RoomAircondition == "on"){
                        $intRoomTAirconditioned = 1;
                    }
                    else{
                        $intRoomTAirconditioned = 0;
                    }
                    
                    if($RoomCategory == "Room"){
                        $intRoomTCategory = 1;
                    }
                    else{
                        $intRoomTCategory = 0;
                    }
                    
                    

                    $data = array('strRoomTypeID'=>$RoomTypeCode,
                                 'strRoomType'=>$RoomTypeName,
                                 'intRoomTCapacity'=>$RoomCapacity,
                                 'intRoomTNoOfBeds'=>$NoOfBeds,
                                 'intRoomTNoOfBathrooms'=>$NoOfBathrooms,
                                 'intRoomTAirconditioned'=>$intRoomTAirconditioned,
                                 'intRoomTCategory'=>$intRoomTCategory,
                                 'strRoomDescription'=>$RoomDescription,
                                 'intRoomTDeleted'=>'1',
                                 'tmsCreated'=>$DateCreated);
                    
                    DB::table('tblRoomType')->insert($data);

                    return $this->storeRoomRate($RoomTypeCode, $RoomRate, $DateCreated);
                }
        
            }
    }
    
    //Add Room Rate
    public function storeRoomRate($RoomTypeCode, $RoomRate, $DateCreated){
        $data = array('strRoomTypeID'=>$RoomTypeCode,
                     'dblRoomRate'=>$RoomRate,
                     'dtmRoomRateAsOf'=>$DateCreated);
        
        DB::table('tblRoomRate')->insert($data);
        
        \Session::flash('flash_message','Successfully added.');
        
        return redirect('Maintenance/RoomType');
    }
    
    //Check duplicate Room Type
    
    public function checkRoomType(Request $req){
        $OldRoomTypeCode = trim($req->input('OldRoomTypeCode'));
        $OldRoomTypeName = trim($req->input('OldRoomTypeName'));
        $OldRoomRate = trim($req->input('OldRoomRate'));
        
        $RoomTypeCode = trim($req->input('EditRoomTypeCode'));
        $RoomTypeName = trim($req->input('EditRoomTypeName'));
        
        $RoomCapacity = trim($req->input('EditRoomCapacity'));
        $RoomRate = trim($req->input('EditRoomRate'));
        $NoOfBeds = trim($req->input('EditNoOfBeds'));
        $NoOfBathrooms = trim($req->input('EditNoOfBathrooms'));
        $RoomDescription;
        $intRoomTAirconditioned;
        $RoomAircondition = $req->input('EditAirconditioned');
        $RoomCategory = $req->input('EditRoomCategory');
        $intRoomTCategory;
        
        $DuplicateChecker = false;
        $ErrorMessage;
        if(!empty(trim($req->input('EditRoomDescription')))){
            $RoomDescription = trim($req->input('EditRoomDescription'));
        }
        else{
            $RoomDescription = "N/A";
        }

        if($RoomAircondition == "on"){
            $intRoomTAirconditioned = 1;
        }
        else{
            $intRoomTAirconditioned = 0;
        }
        
        if($RoomCategory == "Room"){
            $intRoomTCategory = 1;
        }
        else{
            $intRoomTCategory = 0;
        }
        
        
        /*Check Duplicate*/
        
        if($OldRoomTypeCode != $RoomTypeCode && $OldRoomTypeName != $RoomTypeName){
            $DuplicateError = DB::table('tblRoomType')
                ->where([['intRoomTDeleted', '1'], ['strRoomTypeID', $RoomTypeCode], ['strRoomType', $RoomTypeName]])->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Accomodation ID/Name is already taken. Please enter a new one to continue.";
            }
            else{
                $DuplicateError2 = DB::table('tblRoomType')
                ->where('intRoomTDeleted', '1')
                ->where(function($query) use($RoomTypeCode, $RoomTypeName){
                    $query->where('strRoomTypeID', $RoomTypeCode)
                          ->orWhere('strRoomType', $RoomTypeName);
                })
                ->first();
                if($DuplicateError2){
                    $DuplicateChecker = true;
                    $ErrorMessage = "Accomodation ID/Name is already taken. Please enter a new one to continue.";
                }
            }
        }
        
        if($OldRoomTypeCode != $RoomTypeCode){
            $DuplicateError = DB::table('tblRoomType')
                ->where('strRoomTypeID', $RoomTypeCode)->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Accomodation ID is already taken. Please enter a new one to continue.";
            }
        }
        
        
        if($OldRoomTypeName != $RoomTypeName){
            $DuplicateError = DB::table('tblRoomType')
                ->where([['intRoomTDeleted', '1'],['strRoomType', $RoomTypeName]])->first();


            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Name is already taken. Please enter a new one to continue.";
            }
        }
        
        if($DuplicateChecker){
            
            \Session::flash('duplicate_message',$ErrorMessage);
            return redirect('Maintenance/RoomType')->withInput();
        }
        else{
            return $this->updateRoomType($OldRoomTypeCode, $OldRoomTypeName, $RoomTypeCode, $RoomTypeName, $RoomCapacity, $RoomRate, $NoOfBeds, $NoOfBathrooms, $RoomDescription, $intRoomTAirconditioned, $OldRoomRate, $intRoomTCategory);
        }
        
        
    }
    
    //Update Room Type
    
    public function updateRoomType($OldRoomTypeCode, $OldRoomTypeName, $RoomTypeCode, $RoomTypeName, $RoomCapacity, $RoomRate, $NoOfBeds, $NoOfBathrooms, $RoomDescription, $intRoomTAirconditioned, $OldRoomRate, $intRoomTCategory){
        
        $DateToday = Carbon::now();
        $updateData = array("strRoomTypeID" => $RoomTypeCode, 
                     'strRoomType' => $RoomTypeName,
                     'intRoomTCapacity' => $RoomCapacity,
                     'intRoomTNoOfBeds' => $NoOfBeds,
                     'intRoomTNoOfBathrooms' => $NoOfBathrooms,
                     'strRoomDescription' => $RoomDescription,
                     'intRoomTAirconditioned' => $intRoomTAirconditioned,
                     'intRoomTCategory' => $intRoomTCategory);   
        
        DB::table('tblRoomType')
            ->where('strRoomTypeID', $OldRoomTypeCode)
            ->update($updateData);
        
        if($OldRoomTypeCode != $RoomTypeCode){
            DB::table('tblRoomRate')
            ->where('strRoomTypeID', $OldRoomTypeCode)
            ->update(['strRoomTypeID' => $RoomTypeCode]);
        }
        
        if($OldRoomRate != $RoomRate){
            
            $data = array('strRoomTypeID'=>$RoomTypeCode,
                     'dblRoomRate'=>$RoomRate,
                     'dtmRoomRateAsOf'=>$DateToday);
        
            DB::table('tblRoomRate')->insert($data);
        }
        
         \Session::flash('flash_message','Updated successfully!');

          return redirect('Maintenance/RoomType');
    }
    
    //Delete Room Type
    
    public function deleteRoomType(Request $req){
        $RoomTypeCode = trim($req->input('d-RoomTypeID'));
        
        $ExistingRooms = DB::table('tblRoom')
                        ->where([['strRoomTypeID','=' ,$RoomTypeCode], ['strRoomStatus', "!=", 'deleted']])
                        ->get();
        if($ExistingRooms == null){
            \Session::flash('duplicate_message', 'There are rooms that has the room type you wish to delete. Cannot delete room type!');
            return redirect('Maintenance/RoomType');
        }
        else{
            $ExistingPackage = DB::table('tblPackage as a')
                                ->join ('tblPackageRoom as b', 'a.strPackageID', '=' , 'b.strPackageRPackageID')
                                ->where([['a.strPackageStatus', '!=', 'deleted'], ['b.strPackageRRoomTypeID', '=', $RoomTypeCode]])
                                ->get();
            if(sizeof($ExistingPackage) > 0){
                 \Session::flash('duplicate_message', 'Room Type is currently included in a package. Cannot delete room type!');
                 return redirect('Maintenance/RoomType');
            }
            else{
                DB::table('tblRoomType')
                    ->where('strRoomTypeID', $RoomTypeCode)
                    ->update(['intRoomTDeleted' => '0']);

                \Session::flash('flash_message','Deleted successfully!');

                return redirect('Maintenance/RoomType');
            }
        }
        
    }
    
    
    //BOAT FUNCTIONS
    
    
    //Add Boat
    
    public function storeBoat(Request $req){
        $UserInput = Input::all();
           $rules =  [
                'BoatID' => 'unique:tblBoat,strBoatID',
           ];
        
            $validator = Validator::make($UserInput, $rules);

            if ($validator->fails()) {
                // send back to the page with the input data and errors
                return Redirect::to('/Maintenance/Boat')->withInput()->withErrors($validator);
            }
        
            else{
                $tempBoatName = trim($req->input('BoatName'));
                $BoatNameError = DB::table('tblBoat')->where([['strBoatStatus',"!=", 'deleted'],['strBoatName', $tempBoatName]])->first();
                
                if($BoatNameError){
                    
                    \Session::flash('duplicate_message','Boat name is already taken. Please enter a new one to continue.');
                    return redirect('Maintenance/Boat')->withInput();
                }
                else{
                    $BoatID = trim($req->input('BoatID'));
                    $BoatName = trim($req->input('BoatName'));
                    $BoatCapacity = trim($req->input('BoatCapacity'));
                    $BoatRate = trim($req->input('BoatRate'));
                    $BoatDescription;
                    $DateCreated = Carbon::now();

                    if(!empty(trim($req->input('BoatDescription')))){
                        $BoatDescription = trim($req->input('BoatDescription'));
                    }
                    else{
                        $BoatDescription = "N/A";
                    }

                    $data = array('strBoatID'=>$BoatID,
                                 'strBoatName'=>$BoatName,
                                 'intBoatCapacity'=>$BoatCapacity,
                                 'strBoatStatus'=>'Available',
                                 'strBoatDescription'=>$BoatDescription,
                                 'tmsCreated'=>$DateCreated);

                    DB::table('tblBoat')->insert($data);

                    return $this->storeBoatRate($BoatID, $BoatRate, $DateCreated);
                    
                }
        
        
            }
        
    }
    
    // Add Boat Rate
    
    public function storeBoatRate($BoatID, $BoatRate, $DateCreated){
             
        $data = array('strBoatID'=>$BoatID,
                     'dblBoatRate'=>$BoatRate,
                     'dtmBoatRateAsOf'=>$DateCreated);
        
        DB::table('tblBoatRate')->insert($data);
        
        \Session::flash('flash_message','Boat successfully added!');
        
        return redirect('Maintenance/Boat');
    }
    
    // Check duplicate boats
    
    public function checkBoat(Request $req){
        $OldBoatID = trim($req->input('OldBoatID'));
        $OldBoatName = trim($req->input('OldBoatName'));
        $OldBoatRate = trim($req->input('OldBoatRate'));
        
        $BoatID = trim($req->input('EditBoatID'));
        $BoatName = trim($req->input('EditBoatName'));
        $BoatRate = trim($req->input('EditBoatRate'));
        $BoatStatus = trim($req->input('EditBoatStatus'));
        $BoatCapacity = trim($req->input('EditBoatCapacity'));
        $BoatDescription;
        
        if(!empty(trim($req->input('EditBoatDescription')))){
            $BoatDescription = trim($req->input('EditBoatDescription'));
        }
        else{
            $BoatDescription = "N/A";
        }
        
        $DuplicateChecker = false;
        $ErrorMessage;
        
        if($OldBoatID != $BoatID && $OldBoatName != $BoatName){
            $DuplicateError = DB::table('tblBoat')
            ->where([['strBoatStatus', "!=", 'deleted'], ['strBoatName', "=", $BoatName], ['strBoatID', "=", $BoatID]])->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Boat ID/Boat Name is already taken. Please enter a new one to continue.";
            }
            else{
                $DuplicateError2 = DB::table('tblBoat')
                    ->where('strBoatStatus', "!=", 'deleted')
                    ->where(function($query) use($BoatID, $BoatName){
                    $query->where('strBoatID', $BoatID)
                          ->orWhere('strBoatName', $BoatName);
                    }) 
                    ->first();

                if($DuplicateError2){
                    $DuplicateChecker = true;
                    $ErrorMessage = "Boat ID/Boat Name is already taken. Please enter a new one to continue.";
                }
            }
        }
       if($OldBoatID != $BoatID){
            $DuplicateError = DB::table('tblBoat')
                ->where('strBoatID', "=", $BoatID)->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Boat ID is already taken. Please enter a new one to continue.";
            }
        }
        
        if($OldBoatName != $BoatName){
            $DuplicateError = DB::table('tblBoat')
                ->where([['strBoatStatus', "!=", 'deleted'],['strBoatName', "=", $BoatName]])->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Boat Name is already taken. Please enter a new one to continue.";
            }
        }
        
        if($DuplicateChecker){
            
            \Session::flash('duplicate_message',$ErrorMessage);
            return redirect('Maintenance/Boat')->withInput();
        }
        else{
            return $this->updateBoat($OldBoatID, $OldBoatRate, $BoatID, $BoatName, $BoatStatus, $BoatDescription, $BoatCapacity, $BoatRate);
        }
        
    }
    
    //Update Boat
    
    public function updateBoat($OldBoatID, $OldBoatRate, $BoatID, $BoatName, $BoatStatus, $BoatDescription, $BoatCapacity, $BoatRate){
        $DateToday = Carbon::now();
        $updateData = array("strBoatID" => $BoatID, 
                     'strBoatName' => $BoatName,
                     'intBoatCapacity' => $BoatCapacity,
                     'strBoatStatus' => $BoatStatus,
                     'strBoatDescription' => $BoatDescription);   

        DB::table('tblBoat')
            ->where('strBoatID', $OldBoatID)
            ->update($updateData);
        
        if($OldBoatID != $BoatID){
            DB::table('tblBoatRate')
            ->where('strBoatID', $OldBoatID)
            ->update(['strBoatID' => $BoatID]);
        }
        
        if($OldBoatRate != $BoatRate){ 
            $data = array('strBoatID'=>$BoatID,
                     'dblBoatRate'=>$BoatRate,
                     'dtmBoatRateAsOf'=>$DateToday);
        
            DB::table('tblBoatRate')->insert($data);
        }
                
         \Session::flash('flash_message','Boat successfully updated!');
          return redirect('Maintenance/Boat');
    }
    
    //Delete Boat
    
    public function deleteBoat(Request $req){
        $BoatID = trim($req->input('DeleteBoatID'));
        
        //Checks if the boat is reserved
        $ReservedBoats = DB::table('tblReservationBoat as a')
                                ->join ('tblReservationDetail as b', 'a.strResBReservationID', '=' , 'b.strReservationID')
                                ->join ('tblCustomer as c', 'b.strResDCustomerID', '=' , 'c.strCustomerID')
                                ->select(DB::raw('CONCAT(c.strCustFirstName , " " , c.strCustLastName) AS Name'),
                                        'c.strCustContact',
                                        'c.strCustEmail',
                                        'b.dtmResDArrival',
                                        'b.dtmResDDeparture',
                                        'b.intResDStatus',
                                        DB::raw('b.dteResDBooking AS PickUpTime'))
                                ->where('a.strResBBoatID', '=', $BoatID)
                                ->where(function($query){
                                    $query->where('b.intResDStatus', '=', '1')
                                          ->orWhere('b.intResDStatus', '=', '2');
                                })
                                ->get();
        
        foreach($ReservedBoats as $Detail){
            $tempArr = explode(" ", $Detail->dtmResDArrival);
            $Detail->PickUpTime = date("g:i A", strtotime($tempArr[1]));
            if($Detail->intResDStatus == 1){
                $Detail->intResDStatus = "Floating Reservation";
            }
            else if($Detail->intResDStatus == 2){
                $Detail->intResDStatus = "Confirmed Reservation";
            }
        }
        
        if(sizeof($ReservedBoats) > 0){
            \Session::flash('error_message','Cannot delete boat. The boat is currently reserved by the following:');
            \Session::flash('ReservedBoats', $ReservedBoats);
            return redirect('Maintenance/Boat');  
        }
        else{
            dd($ReservedBoats); 
            dd($Input::all());
            DB::table('tblBoat')
                ->where('strBoatID', $BoatID)
                ->update(['strBoatStatus' => 'deleted']);

            \Session::flash('flash_message','Boat successfully deleted!');

            return redirect('Maintenance/Boat');
        }
        
    }
    
    
    //ITEM FUNCTIONS
    
    
    
    //Add Item
    
    public function storeItem(Request $req){
        $UserInput = Input::all();
           $rules =  [
                'ItemID' => 'unique:tblItem,strItemID',
           ];
        
            $validator = Validator::make($UserInput, $rules);

            if ($validator->fails()) {
                // send back to the page with the input data and errors
                return Redirect::to('/Maintenance/Item')->withInput()->withErrors($validator);
            }
        
            else{
                $tempItemName = trim($req->input('ItemName'));
                $ItemNameError = DB::table('tblItem')->where([['intItemDeleted', '1'],['strItemName', $tempItemName]])->first();
                
                if($ItemNameError){
                    
                    \Session::flash('duplicate_message','Item name is already taken. Please enter a new one to continue.');
                    return redirect('Maintenance/Item')->withInput();
                }
                else{
                    $ItemID = trim($req->input('ItemID'));
                    $ItemName = trim($req->input('ItemName'));
                    $ItemQuantity = trim($req->input('ItemQuantity'));
                    $ItemRate = trim($req->input('ItemRate'));
                    $ItemDescription;
                    $DateCreated = Carbon::now();

                    if(!empty(trim($req->input('ItemDescription')))){
                        $ItemDescription = trim($req->input('ItemDescription'));
                    }
                    else{
                        $ItemDescription = "N/A";
                    }

                    $data = array('strItemID'=>$ItemID,
                                 'strItemName'=>$ItemName,
                                 'intItemQuantity'=>$ItemQuantity,
                                 'intItemDeleted'=>'1',
                                 'strItemDescription'=>$ItemDescription,
                                 'tmsCreated'=>$DateCreated);

                    DB::table('tblItem')->insert($data);

                    return $this->storeItemRate($ItemID, $ItemRate, $DateCreated);
                }
            }
    }
    
    //Add Item Rate
    
    public function storeItemRate($ItemID, $ItemRate, $DateCreated){
        $data = array('strItemID'=>$ItemID,
                     'dblItemRate'=>$ItemRate,
                     'dtmItemRateAsOf'=>$DateCreated);
        
        DB::table('tblItemRate')->insert($data);
        
        \Session::flash('flash_message','successfully saved.');
        
        return redirect('Maintenance/Item');
    }
    
    
    //Check duplicate items
    
    public function checkItem(Request $req){
        $OldItemID = trim($req->input('OldItemID'));
        $OldItemName = trim($req->input('OldItemName'));
        $OldItemRate = trim($req->input('OldItemRate'));
        
        $ItemID = trim($req->input('EditItemID'));
        $ItemName = trim($req->input('EditItemName'));
        $ItemRate = trim($req->input('EditItemRate'));
        $ItemQuantity = trim($req->input('EditItemQuantity'));
        $ItemDescription;
        
        if(!empty(trim($req->input('EditItemDescription')))){
            $ItemDescription = trim($req->input('EditItemDescription'));
        }
        else{
            $ItemDescription = "N/A";
        }
        
        $DuplicateChecker = false;
        $ErrorMessage;
        
        if($OldItemID != $ItemID && $OldItemName != $ItemName){
            $DuplicateError = DB::table('tblItem')
            ->where([['intItemDeleted', '1'], ['strItemName', "=", $ItemName], ['strItemID', "=", $ItemID]])->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Item ID/Item Name is already taken. Please enter a new one to continue.";
            }
            else{
                $DuplicateError2 = DB::table('tblItem')
                    ->where('intItemDeleted', '1')
                    ->where(function($query) use($ItemID, $ItemName){
                    $query->where('strItemID', $ItemID)
                          ->orWhere('strItemName', $ItemName);
                    }) 
                    ->first();

                if($DuplicateError2){
                    $DuplicateChecker = true;
                    $ErrorMessage = "Item ID/Item Name is already taken. Please enter a new one to continue.";
                }
            }
        }
       if($OldItemID != $ItemID){
            $DuplicateError = DB::table('tblItem')
                ->where('strItemID', $ItemID)->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Item ID is already taken. Please enter a new one to continue.";
            }
        }
        
        if($OldItemName != $ItemName){
            $DuplicateError = DB::table('tblItem')
                ->where([['intItemDeleted', '1'],['strItemName', $ItemName]])->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Item Name is already taken. Please enter a new one to continue.";
            }
        }
        
        if($DuplicateChecker){
            
            \Session::flash('duplicate_message',$ErrorMessage);
            return redirect('Maintenance/Item')->withInput();
        }
        else{
            
            return $this->updateItem($OldItemID, $OldItemRate, $ItemID, $ItemName, $ItemRate, $ItemQuantity, $ItemDescription);
        }
    }
    
    //update item
    
    public function updateItem($OldItemID, $OldItemRate, $ItemID, $ItemName, $ItemRate, $ItemQuantity, $ItemDescription){
        $DateToday = Carbon::now();
        $updateData = array("strItemID" => $ItemID, 
                     'strItemName' => $ItemName,
                     'intItemQuantity' => $ItemQuantity,
                     'strItemDescription' => $ItemDescription);   
        
        DB::table('tblItem')
            ->where('strItemID', $OldItemID)
            ->update($updateData);
        
        if($OldItemID != $ItemID){
            DB::table('tblItemRate')
            ->where('strItemID', $OldItemID)
            ->update(['strItemID' => $ItemID]);
        }
        
        if($OldItemRate != $ItemRate){
            
            $data = array('strItemID'=>$ItemID,
                     'dblItemRate'=>$ItemRate,
                     'dtmItemRateAsOf'=>$DateToday);
        
            DB::table('tblItemRate')->insert($data);
        }
        
         \Session::flash('flash_message','Item successfully updated!');

          return redirect('Maintenance/Item');
    }
    
    //Delete Item
    public function deleteItem(Request $req){
        $ItemID = trim($req->input('DeleteItemID'));
        
        //checks if item is included in the package
        $PackageItem = DB::table('tblPackage as a')
                                ->join ('tblPackageItem as b', 'a.strPackageID', '=' , 'b.strPackageIPackageID')
                                ->select('a.strPackageName')
                                ->where([['a.strPackageStatus', '!=', 'deleted'], ['b.strPackageIItemID', '=', $ItemID]])
                                ->get();
        
        //package is included
        if(sizeof($PackageItem) > 0){
            \Session::flash('error_message','Cannot delete rental item because it is currently included in these packages:');
            \Session::flash('PackageItem', $PackageItem);
            return redirect('Maintenance/Item');  
        }
        else{
            DB::table('tblItem')
            ->where('strItemID', $ItemID)
            ->update(['intItemDeleted' => '0']);

            \Session::flash('flash_message','Item successfully deleted!');

            return redirect('Maintenance/Item');
        }
        
    }
    
    
    //ACTIVITY FUNCTIONS
    
    
    
    //Add Activity
    
    public function storeActivity(Request $req){
        $UserInput = Input::all();
           $rules =  [
                'ActivityID' => 'unique:tblBeachActivity,strBeachActivityID',
           ];
        
            $validator = Validator::make($UserInput, $rules);

            if ($validator->fails()) {
                // send back to the page with the input data and errors
                return Redirect::to('/Maintenance/Activity')->withInput()->withErrors($validator);
            }
        
            else{
                $tempActivityName = trim($req->input('ActivityName'));
                $ActivityNameError = DB::table('tblBeachActivity')->where([['strBeachAStatus',"!=", 'deleted'],['strBeachAName', $tempActivityName]])->first();
                
                if($ActivityNameError){
                    
                    \Session::flash('duplicate_message','Beach activity name is already taken. Please enter a new one to continue.');
                    return redirect('Maintenance/Activity')->withInput();
                }
                else{
                    $ActivityID = trim($req->input('ActivityID'));
                    $ActivityName = trim($req->input('ActivityName'));
                    $ActivityRate = trim($req->input('ActivityRate'));
                    $ActivityBoat = $req->input('ActivityBoat');
                    $ActivityDescription;
                    $intBeachABoat;
                    $DateCreated = Carbon::now();

                    if(!empty(trim($req->input('ActivityDescription')))){
                        $ActivityDescription = trim($req->input('ActivityDescription'));
                    }
                    else{
                        $ActivityDescription = "N/A";
                    }

                    if($ActivityBoat == "on"){
                        $intBeachABoat = 1;
                    }
                    else{
                        $intBeachABoat = 0;
                    }

                    $data = array('strBeachActivityID'=>$ActivityID,
                                 'strBeachAName'=>$ActivityName,
                                 'intBeachABoat'=>$intBeachABoat,
                                 'strBeachAStatus'=>'Available',
                                 'strBeachADescription'=>$ActivityDescription,
                                 'tmsCreated'=>$DateCreated);

                    DB::table('tblBeachActivity')->insert($data);

                    return $this->storeActivityRate($ActivityID, $ActivityRate, $DateCreated);
                }
            }
        
        
    }
    
    //Add Activity Rate
    
    public function storeActivityRate($ActivityID, $ActivityRate, $DateCreated){
        $data = array('strBeachActivityID'=>$ActivityID,
                     'dblBeachARate'=>$ActivityRate,
                     'dtmBeachARateAsOf'=>$DateCreated);
        
        DB::table('tblBeachActivityRate')->insert($data);
        
        \Session::flash('flash_message','Beach activity successfully added.');
        
        return redirect('Maintenance/Activity');
    }
    
    //Check duplicate 
    public function checkActivity(Request $req){
        $OldActivityID = trim($req->input('OldActivityID'));
        $OldActivityName = trim($req->input('OldActivityName'));
        $OldActivityRate = trim($req->input('OldActivityRate'));
        
        $ActivityID = trim($req->input('EditActivityID'));
        $ActivityName = trim($req->input('EditActivityName'));
        $ActivityStatus = trim($req->input('EditActivityStatus'));
        $ActivityRate = trim($req->input('EditActivityRate'));
        $ActivityDescription;
        $intBeachABoat;
        $ActivityBoat = $req->input('EditActivityBoat');
        
        $DuplicateChecker = false;
        $ErrorMessage;
        if(!empty(trim($req->input('EditActivityDescription')))){
            $ActivityDescription = trim($req->input('EditActivityDescription'));
        }
        else{
            $ActivityDescription = "N/A";
        }

        if($ActivityBoat == "on"){
            $intBeachABoat = 1;
        }
        else{
            $intBeachABoat = 0;
        }
        
        
        /*Check Duplicate*/
        
        if($OldActivityID != $ActivityID && $OldActivityName != $ActivityName){
            $DuplicateError = DB::table('tblBeachActivity')
                ->where([['strBeachAStatus', "!=", 'deleted'], ['strBeachActivityID', $ActivityID], ['strBeachAName', $ActivityName]])->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Beach Activity ID/Beach Activity Name is already taken. Please enter a new one to continue.";
            }
            else{
                $DuplicateError2 = DB::table('tblBeachActivity')
                ->where('strBeachAStatus',"!=" ,'deleted')
                ->where(function($query) use($ActivityID, $ActivityName){
                    $query->where('strBeachActivityID', $ActivityID)
                          ->orWhere('strBeachAName', $ActivityName);
                })
                ->first();
                if($DuplicateError2){
                    $DuplicateChecker = true;
                    $ErrorMessage = "Beach Activity ID/Beach Activity Name is already taken. Please enter a new one to continue.";
                }
            }
        }
        
        if($OldActivityID != $ActivityID){
            $DuplicateError = DB::table('tblBeachActivity')
                ->where('strBeachActivityID', $ActivityID)->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Beach Activity ID is already taken. Please enter a new one to continue.";
            }
        }
        
        
        if($OldActivityName != $ActivityName){
            $DuplicateError = DB::table('tblBeachActivity')
                ->where([['strBeachAStatus',"!=",'deleted'],['strBeachAName', $ActivityName]])->first();


            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Beach Activity name is already taken. Please enter a new one to continue.";
            }
        }
        
        if($DuplicateChecker){
            
            \Session::flash('duplicate_message',$ErrorMessage);
            return redirect('Maintenance/Activity')->withInput();
        }
        else{
            
            return $this->updateActivity($OldActivityID, $OldActivityRate, $ActivityID, $ActivityName, $ActivityRate, $ActivityStatus, $intBeachABoat, $ActivityDescription);
        }
    }
    
    
    //update activity
    
    public function updateActivity($OldActivityID, $OldActivityRate, $ActivityID, $ActivityName, $ActivityRate, $ActivityStatus, $intBeachABoat, $ActivityDescription){
        
        $DateToday = Carbon::now();
        $updateData = array("strBeachActivityID" => $ActivityID, 
                            'strBeachAName' => $ActivityName,
                            'strBeachAStatus' => $ActivityStatus,
                            'intBeachABoat' => $intBeachABoat,
                            'strBeachADescription' => $ActivityDescription);   
        
        DB::table('tblBeachActivity')
            ->where('strBeachActivityID', $OldActivityID)
            ->update($updateData);
        
        if($OldActivityID != $ActivityID){
            DB::table('tblBeachActivityRate')
            ->where('strBeachActivityID', $OldActivityID)
            ->update(['strBeachActivityID' => $ActivityID]);
        }
        
        if($OldActivityRate != $ActivityRate){
            
            $data = array('strBeachActivityID'=>$ActivityID,
                     'dblBeachARate'=>$ActivityRate,
                     'dtmBeachARateAsOf'=>$DateToday);
        
            DB::table('tblBeachActivityRate')->insert($data);
        }
        

         \Session::flash('flash_message','Beach Activity successfully updated!');

          return redirect('Maintenance/Activity');

    }
    
    
    //delete activity
    public function deleteActivity(Request $req){
        $ActivityID = trim($req->input('DeleteActivityID'));

        //checks if item is included in the package
        $PackageActivity = DB::table('tblPackage as a')
                                ->join ('tblPackageActivity as b', 'a.strPackageID', '=' , 'b.strPackageAPackageID')
                                ->select('a.strPackageName')
                                ->where([['a.strPackageStatus', '!=', 'deleted'], ['b.strPackageABeachActivityID', '=', $ActivityID]])
                                ->get();

        //package is included
        if(sizeof($PackageActivity) > 0){
            \Session::flash('error_message','Cannot delete beach activity because it is currently included in these packages:');
            \Session::flash('PackageActivity', $PackageActivity);
            return redirect('Maintenance/Activity');  
        }
        else{
            DB::table('tblBeachActivity')
            ->where('strBeachActivityID', $ActivityID)
            ->update(['strBeachAStatus' => 'deleted']);

            \Session::flash('flash_message','Beach Activity successfully deleted!');

            return redirect('Maintenance/Activity');
        }
    }
    
    
    //ROOM FUNCTIONS//
    
    
    
    //Add Room
    
    public function storeRoom(Request $req){
        $UserInput = Input::all();
           $rules =  [
                'RoomID' => 'unique:tblRoom,strRoomID',
           ];
        
            $validator = Validator::make($UserInput, $rules);

            if ($validator->fails()) {
                // send back to the page with the input data and errors
                return Redirect::to('/Maintenance/Room')->withInput()->withErrors($validator);
            }
        
            else{
                $tempRoomName = trim($req->input('RoomName'));
                $RoomNameError = DB::table('tblRoom')->where([['strRoomStatus',"!=", 'deleted'],['strRoomName', $tempRoomName]])->first();
                
                if($RoomNameError){
                    
                    \Session::flash('duplicate_message','Room name is already taken. Please enter a new one to continue.');
                    return redirect('Maintenance/Room')->withInput();
                }
                else{
                    $RoomID = trim($req->input('RoomID'));
                    $RoomName = trim($req->input('RoomName'));
                    $RoomType = trim($req->input('RoomType'));
                    $DateCreated = Carbon::now();

                    $RoomTypeID = DB::table('tblRoomType')->where('strRoomType', $RoomType)->pluck('strRoomTypeID')->first();

                    $data = array('strRoomID'=>$RoomID,
                                  'strRoomName'=>$RoomName,
                                  'strRoomTypeID'=>$RoomTypeID,
                                  'strRoomStatus'=>'Available',
                                  'tmsCreated'=>$DateCreated);

                    DB::table('tblRoom')->insert($data);

                    \Session::flash('flash_message','Successfully added.');

                    return redirect('Maintenance/Room');
                }
            }
    }
    
    //Check duplicate
    
    public function checkRoom(Request $req){
        $OldRoomID = trim($req->input('OldRoomID'));
        $OldRoomName = trim($req->input('OldRoomName'));
        
        $RoomID = trim($req->input('EditRoomID'));
        $RoomName = trim($req->input('EditRoomName'));
        $RoomType = trim($req->input('EditRoomType'));
        $RoomStatus = trim($req->input('EditRoomStatus'));
        
        $DuplicateChecker = false;
        $ErrorMessage;
        
        $RoomTypeID = DB::table('tblRoomType')->where('strRoomType', $RoomType)->pluck('strRoomTypeID')->first();
        
        
        if($OldRoomID != $RoomID && $OldRoomName != $RoomName){
            $DuplicateError = DB::table('tblRoom')
                ->where([['strRoomStatus', "!=", 'deleted'], ['strRoomName', "=", $RoomName], ['strRoomID', "=", $RoomID]])->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Room ID/Room Name is already taken. Please enter a new one to continue.";
            }
            else{
                 $DuplicateError2 = DB::table('tblRoom')
                    ->where('strRoomStatus', "!=", 'deleted')
                    ->where(function($query) use($RoomID, $RoomName){
                    $query->where('strRoomID', $RoomID)
                          ->orWhere('strRoomName', $RoomName);
                    }) 
                    ->first();
                
                if($DuplicateError2){
                    $DuplicateChecker = true;
                    $ErrorMessage = "Room ID/Room Name is already taken. Please enter a new one to continue.";
                }
            }
        }
        
        if($OldRoomID != $RoomID){
            $DuplicateError = DB::table('tblRoom')
                ->where('strRoomID', "=", $RoomID)->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Room ID is already taken. Please enter a new one to continue.";
            }
        }
        
        if($OldRoomName != $RoomName){
            $DuplicateError = DB::table('tblRoom')
                ->where([['strRoomStatus', "!=", 'deleted'],['strRoomName', "=", $RoomName]])->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Room Name is already taken. Please enter a new one to continue.";
            }
        }
        
        if($DuplicateChecker){
            
            \Session::flash('duplicate_message',$ErrorMessage);
            return redirect('Maintenance/Room')->withInput();
        }
        else{
            return $this->updateRoom($OldRoomID, $RoomID, $RoomTypeID, $RoomStatus, $RoomName);
        }
        
    }
    
    //Update Room
    
    public function updateRoom($OldRoomID, $RoomID, $RoomTypeID, $RoomStatus, $RoomName){
        $DateToday = Carbon::now();
        $updateData = array("strRoomID" => $RoomID, 
                     'strRoomTypeID' => $RoomTypeID,
                     'strRoomStatus' => $RoomStatus,
                     'strRoomName' => $RoomName);   
        
        DB::table('tblRoom')
            ->where('strRoomID', $OldRoomID)
            ->update($updateData);
        

         \Session::flash('flash_message','Successfully updated!');

          return redirect('Maintenance/Room');

    }
    
    //Delete Room
    
    public function deleteRoom(Request $req){
        $RoomID = trim($req->input('DeleteRoomID'));
        
        //Checks if the room is reserved or checked in
        $ReservationDetail = DB::table('tblReservationRoom as a')
                                ->join ('tblReservationDetail as b', 'a.strResRReservationID', '=' , 'b.strReservationID')
                                ->join ('tblCustomer as c', 'b.strResDCustomerID', '=' , 'c.strCustomerID')
                                ->select(DB::raw('CONCAT(c.strCustFirstName , " " , c.strCustLastName) AS Name'),
                                        'c.strCustContact',
                                        'c.strCustEmail',
                                        'b.dtmResDArrival',
                                        'b.dtmResDDeparture',
                                        'b.intResDStatus')
                                ->where('a.strResRRoomID', '=', $RoomID)
                                ->where(function($query){
                                    $query->where('b.intResDStatus', '!=', '3')
                                          ->orWhere('b.intResDStatus', '!=', '5');
                                })
                                ->get();
        foreach($ReservationDetail as $Detail){
            if($Detail->intResDStatus == 1){
                $Detail->intResDStatus = "Floating Reservation";
            }
            else if($Detail->intResDStatus == 2){
                $Detail->intResDStatus = "Confirmed Reservation";
            }
            else if($Detail->intResDStatus == 4){
                $Detail->intResDStatus = "Checked in";
            }
        }
        if(sizeof($ReservationDetail) > 0){
            \Session::flash('error_message','Cannot delete room. Rooms are currently being used/reserved by the following:');
            \Session::flash('ReservationDetail', $ReservationDetail);
            return redirect('Maintenance/Room');   
        }
        else{
            DB::table('tblRoom')
            ->where('strRoomID', $RoomID)
            ->update(['strRoomStatus' => 'deleted']);

            \Session::flash('flash_message','Successfully deleted!');

            return redirect('Maintenance/Room');
        }
    }
    
    
    
    //FEE FUNCTIONS
    
    //Add Fee
    public function storeFee(Request $req){
        $UserInput = Input::all();
           $rules =  [
                'FeeID' => 'unique:tblFee,strFeeID',
           ];
        
            $validator = Validator::make($UserInput, $rules);

            if ($validator->fails()) {
                // send back to the page with the input data and errors
                return Redirect::to('/Maintenance/Operations')->withInput()->withErrors($validator);
            }
        
            else{
                $tempFeeName = trim($req->input('FeeName'));
                $FeeNameError = DB::table('tblFee')->where([['strFeeStatus',"!=", 'deleted'],['strFeeName', $tempFeeName]])->first();
                
                if($FeeNameError){
                    
                    \Session::flash('duplicate_message','Fee name already exists. Please enter a new one to continue.');
                    return redirect('Maintenance/Operations')->withInput();
                }
                else{
                    $FeeID = trim($req->input('FeeID'));
                    $FeeName = trim($req->input('FeeName'));
                    $FeeAmount = trim($req->input('FeeAmount'));
                    $FeeDescription;
                    $DateCreated = Carbon::now();
                    if(!empty(trim($req->input('FeeDescription')))){
                        $FeeDescription = trim($req->input('FeeDescription'));
                    }
                    else{
                        $FeeDescription = "N/A";
                    }


                    $data = array('strFeeID'=>$FeeID,
                                 'strFeeName'=>$FeeName,
                                 'strFeeStatus'=>'Active',
                                 'strFeeDescription'=>$FeeDescription,
                                 'tmsCreated'=>$DateCreated);

                    DB::table('tblFee')->insert($data);

                    return $this->storeFeeAmount($FeeID, $FeeAmount, $DateCreated);
                }
            }
    }
    
    //Add Fee Amount
    public function storeFeeAmount($FeeID, $FeeAmount, $DateCreated){
        $data = array('strFeeID'=>$FeeID,
                     'dblFeeAmount'=>$FeeAmount,
                     'dtmFeeAmountAsOf'=>$DateCreated);
        
        DB::table('tblFeeAmount')->insert($data);
        
        \Session::flash('flash_message','Fee successfully added.');
        
        return redirect('Maintenance/Fee');
    }
    
    //Check Duplicate
    
    public function checkFee(Request $req){
        $OldFeeID = trim($req->input('OldFeeID'));
        $OldFeeName = trim($req->input('OldFeeName'));
        $OldFeeAmount = trim($req->input('OldFeeAmount'));
        
        $FeeID = trim($req->input('EditFeeID'));
        $FeeName = trim($req->input('EditFeeName'));
        $FeeAmount = trim($req->input('EditFeeAmount'));
        $FeeStatus = trim($req->input('EditFeeStatus'));
        $FeeDescription;
        
        if(!empty(trim($req->input('EditFeeDescription')))){
            $FeeDescription = trim($req->input('EditFeeDescription'));
        }
        else{
            $FeeDescription = "N/A";
        }
        
        $DuplicateChecker = false;
        $ErrorMessage;
        
        if($OldFeeID != $FeeID && $OldFeeName != $FeeName){
            $DuplicateError = DB::table('tblFee')
            ->where([['strFeeStatus',"!=", 'deleted'], ['strFeeName', "=", $FeeName], ['strFeeID', "=", $FeeID]])->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Fee ID/Fee Name is already taken. Please enter a new one to continue.";
            }
            else{
                $DuplicateError2 = DB::table('tblFee')
                    ->where('strFeeStatus',"!=", 'deleted')
                    ->where(function($query) use($FeeID, $FeeName){
                    $query->where('strFeeID', $FeeID)
                          ->orWhere('strFeeName', $FeeName);
                    }) 
                    ->first();

                if($DuplicateError2){
                    $DuplicateChecker = true;
                    $ErrorMessage = "Fee ID/Fee Name is already taken. Please enter a new one to continue.";
                }
            }
        }
       if($OldFeeID != $FeeID){
            $DuplicateError = DB::table('tblFee')
                ->where('strFeeID', $FeeID)->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Fee ID is already taken. Please enter a new one to continue.";
            }
        }
        
        if($OldFeeName != $FeeName){
            $DuplicateError = DB::table('tblFee')
                ->where([['strFeeStatus',"!=", 'deleted'],['strFeeName', $FeeName]])->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Fee Name is already taken. Please enter a new one to continue.";
            }
        }
        
        if($DuplicateChecker){
            
            \Session::flash('duplicate_message',$ErrorMessage);
            return redirect('Maintenance/Operations')->withInput();
        }
        else{
            return $this->updateFee($OldFeeID, $OldFeeAmount, $FeeID, $FeeName, $FeeAmount, $FeeStatus, $FeeDescription);
        }
    }
    
    //Update Fee
    
    public function updateFee($OldFeeID, $OldFeeAmount, $FeeID, $FeeName, $FeeAmount, $FeeStatus, $FeeDescription){
        $DateToday = Carbon::now();
        $updateData = array("strFeeID" => $FeeID, 
                     'strFeeName' => $FeeName,
                     'strFeeStatus' => $FeeStatus,
                     'strFeeDescription' => $FeeDescription);   
        
        DB::table('tblFee')
            ->where('strFeeID', $OldFeeID)
            ->update($updateData);
        
        if($OldFeeID != $FeeID){
            DB::table('tblFeeAmount')
            ->where('strFeeID', $OldFeeID)
            ->update(['strFeeID' => $FeeID]);
        }
        
        if($OldFeeAmount != $FeeAmount){
            
            $data = array('strFeeID'=>$FeeID,
                     'dblFeeAmount'=>$FeeAmount,
                     'dtmFeeAmountAsOf'=>$DateToday);
        
            DB::table('tblFeeAmount')->insert($data);
        }
        
         \Session::flash('flash_message','Fee successfully updated!');

          return redirect('Maintenance/Fee');
    }
    
    //Delete Fee
    
    public function deleteFee(Request $req){
        $FeeID = trim($req->input('DeleteFeeID'));

        $PackageFee = DB::table('tblPackage as a')
                            ->join ('tblPackageFee as b', 'a.strPackageID', '=' , 'b.strPackageFPackageID')
                            ->select('a.strPackageName')
                            ->where([['a.strPackageStatus', '!=', 'deleted'], ['b.strPackageFFeeID', '=', $FeeID]])
                            ->get();
        

        //package is included
        if(sizeof($PackageFee) > 0){
        \Session::flash('error_message','Cannot delete fee because it is currently included in these packages:');
        \Session::flash('PackageFee', $PackageFee);
        return redirect('Maintenance/Fee');  
        }
        else{
            DB::table('tblFee')
            ->where('strFeeID', $FeeID)
            ->update(['strFeeStatus' => 'deleted']);

            \Session::flash('flash_message','Fee successfully deleted!');

            return redirect('Maintenance/Fee');
        }
        
    }
    
    
    // PACKAGE FUNCTIONS //
    
    public function storePackage(Request $req){
        $includedRooms = ($req->input('includedRooms'));
        $includedItems = ($req->input('includedItems'));
        $includedActivities = ($req->input('includedActivities'));
        $includedFees = ($req->input('includedFees'));
        $UserInput = Input::all();
           $rules =  [
                'PackageID' => 'unique:tblPackage,strPackageID',
           ];
        
            $validator = Validator::make($UserInput, $rules);

            if ($validator->fails()) {
                // send back to the page with the input data and errors
                \Session::flash('includedRooms', $includedRooms);
                \Session::flash('includedItems', $includedItems);
                \Session::flash('includedActivities', $includedActivities);
                \Session::flash('includedFees', $includedFees);
                return Redirect::to('/Maintenance/Package/Add')->withInput()->withErrors($validator);
                
            }
        
            else{
                $tempPackageName = trim($req->input('PackageName'));
                $RoomNameError = DB::table('tblPackage')->where([['strPackageStatus',"!=", 'deleted'],['strPackageName', $tempPackageName]])->first();
            
                if($RoomNameError){
                    
                    \Session::flash('duplicate_message', 'Package name is already taken. Please enter a new one to continue.');
                    \Session::flash('includedRooms', $includedRooms);
                    \Session::flash('includedItems', $includedItems);
                    \Session::flash('includedActivities', $includedActivities);
                    \Session::flash('includedFees', $includedFees);
                    return redirect('Maintenance/Package/Add')->withInput();
                }
                else{
                    $PackageID = trim($req->input('PackageID'));
                    $PackageName = trim($req->input('PackageName'));
                    $PackagePrice = trim($req->input('PackagePrice'));
                    $PackagePax = trim($req->input('PackagePax'));
                    $PackageDuration = trim($req->input('PackageDuration'));
                    $PackageTransportation = trim($req->input('PackageTransportation'));
                    $intBoatFee;
                    $PackageDescription;
                    if(trim($req->input('PackageDescription')) == null){
                        $PackageDescription = "N/A";
                    }
                    else{
                        $PackageDescription = trim($req->input('PackageDescription'));
                    }
                    if($PackageTransportation == "on"){
                        $intBoatFee = 1;
                    }
                    else{
                        $intBoatFee = 0;
                    }
                    $DateCreated = Carbon::now();
                    
                    $data = array('strPackageID'=>$PackageID,
                                  'strPackageName'=>$PackageName,
                                  'intPackagePax'=>$PackagePax,
                                  'intPackageDuration'=>$PackageDuration,
                                  'strPackageDescription'=>$PackageDescription,
                                  'tmsCreated'=>$DateCreated,
                                  'strPackageStatus'=>'Available',
                                  'intBoatFee'=>$intBoatFee
                                 );
                    DB::table('tblPackage')->insert($data);
                               
                    $this->savePackageInclusion($includedRooms, $includedItems, $includedActivities, $includedFees, $PackageID);
                    
                    return $this->storePackageRate($PackageID, $PackagePrice, $DateCreated);
                }
            }
        }
    
    //store Package Rate
    
    public function storePackageRate($PackageID, $PackagePrice, $DateCreated){
        $data = array('strPackageID'=>$PackageID,
                      'dblPackagePrice'=>$PackagePrice,
                      'dtmPackagePriceAsOf'=>$DateCreated);
        
        DB::table('tblPackagePrice')->insert($data);
        
        \Session::flash('flash_message','Package successfully successfully created.');
        
        return redirect('Maintenance/Package');
    }
    
    //Check Duplicate
    
    public function checkPackage(Request $req){
        $includedRooms = ($req->input('includedRooms'));
        $includedItems = ($req->input('includedItems'));
        $includedActivities = ($req->input('includedActivities'));
        $includedFees = ($req->input('includedFees'));
        
        $OldPackageID = trim($req->input('OldPackageID'));
        $OldPackageName = trim($req->input('OldPackageName'));
        
        $PackageID = trim($req->input('EditPackageID'));
        $PackageName = trim($req->input('EditPackageName'));
        
        $DuplicateChecker = false;
        $ErrorMessage;

        /*Check Duplicate*/
        
        if(($OldPackageID != $PackageID) && ($OldPackageName != $PackageName)){
            $DuplicateError = DB::table('tblPackage')
                ->where([['strPackageStatus', "!=", 'deleted'], ['strPackageID', $PackageID], ['strPackageName', $PackageName]])->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Package ID/Package Name is already taken. Please enter a new one to continue.";
            }
            else{
                $DuplicateError2 = DB::table('tblPackage')
                ->where('strPackageStatus',"!=" ,'deleted')
                ->where(function($query) use($PackageID, $PackageName){
                    $query->where('strPackageID', $PackageID)
                          ->orWhere('strPackageName', $PackageName);
                })
                ->first();
                if($DuplicateError2){
                    $DuplicateChecker = true;
                    $ErrorMessage = "Package ID/Package Name is already taken. Please enter a new one to continue.";
                }
            }
        }
        
        if($OldPackageID != $PackageID){
            $DuplicateError = DB::table('tblPackage')
                ->where('strPackageID', $PackageID)->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Package ID is already taken. Please enter a new one to continue.";
            }
        }
        
        
        if($OldPackageName != $PackageName){
            $DuplicateError = DB::table('tblPackage')
                ->where([['strPackageStatus',"!=",'deleted'],['strPackageName', $PackageName]])->first();


            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Package name is already taken. Please enter a new one to continue.";
            }
        }
        
        if($DuplicateChecker){
            \Session::flash('includedRooms', $includedRooms);
            \Session::flash('includedItems', $includedItems);
            \Session::flash('includedActivities', $includedActivities);
            \Session::flash('includedFees', $includedFees);
            \Session::flash('duplicate_message',$ErrorMessage);
            
            return redirect('Maintenance/Package/Edit/'.$OldPackageID)->withInput();
        }
        else{
            $PackagePax = trim($req->input('EditPackagePax'));
            $PackageDuration = trim($req->input('EditPackageDuration'));
            $PackagePrice = trim($req->input('EditPackagePrice'));
            $PackageStatus = trim($req->input('EditPackageStatus'));
            $PackageDescription = trim($req->input('EditPackageDescription'));
            $OldPackagePrice = trim($req->input('OldPackagePrice'));
            $PackageTransportation;
            if(($req->input('EditPackageTransportation')) == "on"){
                $PackageTransportation = 1;
            }
            else{
                $PackageTransportation = 0;
            }
            
            return $this->updatePackage($OldPackageID, $OldPackagePrice, $PackageID, $PackageName, $PackagePrice, $PackageStatus, $PackageDescription, $PackagePax, $PackageDuration, $includedRooms, $includedItems, $includedActivities, $includedFees, $PackageTransportation);
        }
    
    }
    
    //Update Package
    
    public function updatePackage($OldPackageID, $OldPackagePrice, $PackageID, $PackageName, $PackagePrice, $PackageStatus, $PackageDescription, $PackagePax, $PackageDuration, $includedRooms, $includedItems, $includedActivities, $includedFees, $PackageTransportation){
        
        DB::table('tblPackageActivity')->where('strPackageAPackageID', '=', $OldPackageID)->delete();
        DB::table('tblPackageItem')->where('strPackageIPackageID', '=', $OldPackageID)->delete();
        DB::table('tblPackageRoom')->where('strPackageRPackageID', '=', $OldPackageID)->delete();
        DB::table('tblPackageFee')->where('strPackageFPackageID', '=', $OldPackageID)->delete();

        $DateToday = Carbon::now();
        $updateData = array("strPackageID" => $PackageID, 
                            'strPackageName' => $PackageName,
                            'strPackageStatus' => $PackageStatus,
                            'intPackagePax' => $PackagePax,
                            'intPackageDuration' => $PackageDuration,
                            'strPackageDescription' => $PackageDescription,
                            'intBoatFee' => $PackageTransportation);   
        
        DB::table('tblPackage')
            ->where('strPackageID', $OldPackageID)
            ->update($updateData);
        
        if($OldPackageID != $PackageID){
            DB::table('tblPackagePrice')
            ->where('strPackageID', $OldPackageID)
            ->update(['strPackageID' => $PackageID]);
        }
        
        if($OldPackagePrice != $PackagePrice){
            
            $data = array('strPackageID'=>$PackageID,
                     'dblPackagePrice'=>$PackagePrice,
                     'dtmPackagePriceAsOf'=>$DateToday);
        
            DB::table('tblPackagePrice')->insert($data);
        }
        
        $this->savePackageInclusion($includedRooms, $includedItems, $includedActivities, $includedFees, $PackageID);
        

         \Session::flash('flash_message','Package successfully successfully updated.');
        
         return redirect('Maintenance/Package');
    }
    
    //Add Package Inclusions
    public function savePackageInclusion($includedRooms, $includedItems, $includedActivities, $includedFees, $PackageID){
        if($includedRooms!=null){
                $arrRoomTypeData = explode(",", $includedRooms);
                $intRoomTypeDataLength = count($arrRoomTypeData);
                for($i = 0; $i < $intRoomTypeDataLength; $i++){

                    $arrTemp = explode("-", $arrRoomTypeData[$i]);

                    $RoomTypeID = DB::table('tblRoomType')->where([['strRoomType', $arrTemp[0]],['intRoomTDeleted', '1']])->pluck('strRoomTypeID')->first();

                    $data = array('strPackageRPackageID'=>$PackageID,
                                  'strPackageRRoomTypeID'=>$RoomTypeID,
                                  'intPackageRQuantity'=>$arrTemp[1]);

                        DB::table('tblPackageRoom')->insert($data);
                    }

            }

            if($includedItems!=null){
                $arrItemData = explode(",", $includedItems);
                $intItemDataLength = count($arrItemData);
                for($i = 0; $i < $intItemDataLength; $i++){
                    $arrTemp = explode("-", $arrItemData[$i]);

                    $ItemID = DB::table('tblItem')->where([['strItemName', $arrTemp[0]],['intItemDeleted', '1']])->pluck('strItemID')->first();

                    $data = array('strPackageIPackageID'=>$PackageID,
                                  'strPackageIItemID'=>$ItemID,
                                  'intPackageIQuantity'=>$arrTemp[1],
                                  'flPackageIDuration'=>$arrTemp[2]);

                    DB::table('tblPackageItem')->insert($data);
                }
            }

            if($includedActivities!=null){
                $arrActivityData = explode(",", $includedActivities);
                $intActivityDataLength = count($arrActivityData);
                for($i = 0; $i < $intActivityDataLength; $i++){
                    $arrTemp = explode("-", $arrActivityData[$i]);
                    $ActivityID = DB::table('tblBeachActivity')->where([['strBeachAName',"=", $arrTemp[0]],['strBeachAStatus',"!=", 'deleted']])->pluck('strBeachActivityID')->first();  

                    $data = array('strPackageAPackageID'=>$PackageID,
                                  'strPackageABeachActivityID'=>$ActivityID,
                                  'intPackageAQuantity'=>$arrTemp[1]);

                    DB::table('tblPackageActivity')->insert($data);
                }
            }
        
            if($includedFees != null){
                
                $arrFeeData = explode(",", $includedFees);
                $intFeeDataLength = count($arrFeeData);
                for($i = 0; $i < $intFeeDataLength; $i++){
                    $arrTemp = explode("-", $arrFeeData[$i]);
                    $FeeID = DB::table('tblFee')->where([['strFeeName',"=", $arrTemp[0]],['strFeeStatus',"!=", 'deleted']])->pluck('strFeeID')->first();  

                    $data = array('strPackageFPackageID'=>$PackageID,
                                  'strPackageFFeeID'=>$FeeID);

                    DB::table('tblPackageFee')->insert($data);
                }
            }
    }
    
    //Delete Package
    
    public function deletePackage(Request $req){
        $PackageID = trim($req->input('DeletePackageID'));
        DB::table('tblPackage')
            ->where('strPackageID', $PackageID)
            ->update(['strPackageStatus' => 'deleted']);

        \Session::flash('flash_message','Package successfully deleted!');

        return redirect('Maintenance/Package');
    }
    
    
    //OPERATION FUNCTIONS
    
    //add Dates
    public function storeOperation(Request $req){
        $UserInput = Input::all();
           $rules =  [
                'DateID' => 'unique:tblInoperationalDate,strDateID',
           ];
        
            $validator = Validator::make($UserInput, $rules);

            if ($validator->fails()) {
                // send back to the page with the input data and errors
                return Redirect::to('/Maintenance/Operations')->withInput()->withErrors($validator);
            }
        
            else{
                $tempDateName = trim($req->input('DateName'));
                $DateNameError = DB::table('tblInoperationalDate')->where([['intDateStatus',"!=", '0'],['strDateTitle', $tempDateName]])->first();
                
                if($DateNameError){
                    
                    \Session::flash('duplicate_message','Title already exists. Please enter a new one to continue.');
                    return redirect('Maintenance/Operations')->withInput();
                }
                else{
                    $DateID = trim($req->input('DateID'));
                    $DateTitle = trim($req->input('DateName'));
                    $StartDate = trim($req->input('StartDate'));
                    $EndDate = trim($req->input('EndDate'));
                    
                    $DateDescription;
                    $DateCreated = Carbon::now();
                    if(!empty(trim($req->input('DateDescription')))){
                        $DateDescription = trim($req->input('DateDescription'));
                    }
                    else{
                        $DateDescription = "N/A";
                    }

                    $data = array('strDateID'=>$DateID,
                                 'strDateTitle'=>$DateTitle,
                                 'dteStartDate'=>Carbon::parse($StartDate)->format('Y-m-d'),
                                 'dteEndDate'=>Carbon::parse($EndDate)->format('Y-m-d'),
                                 'intDateStatus'=>1,
                                 'strDateDescription'=>$DateDescription,
                                 'tmsCreated'=>$DateCreated);

                    DB::table('tblInoperationalDate')->insert($data);
                    
                    \Session::flash('flash_message','Added successfully!');
        
                    return redirect('Maintenance/Operations');
                }
            }
    }
    
    //Check Duplicate
    public function checkOperation(Request $req){     
        $OldDateID = trim($req->input('OldDateID'));
        $OldDateName = trim($req->input('OldDateName'));
        
        $DateID = trim($req->input('EditDateID'));
        $DateName = trim($req->input('EditDateName'));
        
        $DuplicateChecker = false;
        $ErrorMessage;

        /*Check Duplicate*/
        
        if(($OldDateID != $DateID) && ($OldDateName != $DateName)){
            $DuplicateError = DB::table('tblInoperationalDate')
                ->where([['intDateStatus', "!=", '0'], ['strDateID', $DateID], ['strDateTitle', $DateName]])->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "ID/Title is already taken. Please enter a new one to continue.";
            }
            else{
                $DuplicateError2 = DB::table('tblInoperationalDate')
                ->where('intDateStatus',"!=" ,'0')
                ->where(function($query) use($DateID, $DateName){
                    $query->where('strDateID', $DateID)
                          ->orWhere('strDateTitle', $DateName);
                })
                ->first();
                if($DuplicateError2){
                    $DuplicateChecker = true;
                    $ErrorMessage = "ID/Title is already taken is already taken. Please enter a new one to continue.";
                }
            }
        }
        
        if($OldDateID != $DateID){
            $DuplicateError = DB::table('tblInoperationalDate')
                ->where('strDateID', $DateID)->first();

            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "ID is already taken. Please enter a new one to continue.";
            }
        }
        
        
        if($OldDateName != $DateName){
            $DuplicateError = DB::table('tblInoperationalDate')
                ->where([['intDateStatus',"!=",'0'],['strDateTitle', $DateName]])->first();


            if($DuplicateError){
                $DuplicateChecker = true;
                $ErrorMessage = "Title is already taken. Please enter a new one to continue.";
            }
        }
        
        if($DuplicateChecker){
            \Session::flash('duplicate_message',$ErrorMessage);
            return redirect('Maintenance/Operations')->withInput();
        }
        else{
            $StartDate = trim($req->input('EditStartDate'));
            $EndDate = trim($req->input('EditEndDate'));
            $DateDescription = trim($req->input('EditDateDescription'));
            $DateStatus = trim($req->input('EditDateStatus'));
            
            return $this->updateOperation($DateID, $DateName, $DateStatus, $StartDate, $EndDate, $DateDescription, $OldDateID);
        }
    }
    
    //update dates
    public function updateOperation($DateID, $DateTitle, $DateStatus, $StartDate, $EndDate, $DateDescription, $OldDateID){
        
        if($DateStatus == "Inactive"){
            $DateStatus = "2";
        }
        else{
            $DateStatus = "1";
        }
        
        if($DateDescription == null){
            $DateDescription = "N/A";
        }
        
        $updateData = array("strDateID" => $DateID, 
                            'strDateTitle' => $DateTitle,
                            'intDateStatus' => $DateStatus,
                            'dteStartDate' => Carbon::parse($StartDate)->format('Y-m-d'),
                            'dteEndDate' => Carbon::parse($EndDate)->format('Y-m-d'),
                            'strDateDescription' => $DateDescription);   
        
        DB::table('tblInoperationalDate')
            ->where('strDateID', $OldDateID)
            ->update($updateData);
        

         \Session::flash('flash_message','Successfully updated!');

          return redirect('Maintenance/Operations');

    }
    
    //delete date
    public function deleteOperation(Request $req){
        $DateID = trim($req->input('DeleteDateID'));
        DB::table('tblInoperationalDate')
            ->where('strDateID', $DateID)
            ->update(['intDateStatus' => '0']);

        \Session::flash('flash_message','Successfully deleted!');

        return redirect('Maintenance/Operations');
    }
}


    