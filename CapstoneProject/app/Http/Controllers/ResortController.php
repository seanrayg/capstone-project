<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use DatePeriod;
use DateInterval;

class ResortController extends Controller
{
    //
    
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
    
    /* ACTIVITY REFERENCE
    
    intAvailBAPayment
     0 = not paid
     1 = paid;
    
    */
    
    // Room Payment Status reference
    
    // 1 3 5 7 paid 
    // 0 2 4 6 not paid

    // 3 paid add rooms

    // 2 not paid add rooms

    // 7 paid add rooms and paid upgrade room ---- paid add rooms and paid upgrade room

    // 6 not paid add rooms and not paid upgrade room ------ not paid add rooms and not paid upgrade room
        
    
    
    /*------------ ITEM RENTAL -------------*/
    
    //rent item
    public function storeRentalItem(Request $req){

        $ItemID = trim($req->input('RentItemID'));
        $CustomerName = trim($req->input('SelectGuests'));
        $RentQuantity = trim($req->input('RentQuantity'));
        $RentDuration = trim($req->input('RentDuration'));
        $RentTotal = trim($req->input('RentItemPrice'));
        $PaymentStatus = 0;
        
        $RentedItemID = $this->saveRentalItem($ItemID, $CustomerName, $RentQuantity, $RentDuration, $PaymentStatus);
        
        $DateToday = Carbon::now()->toDateString();
        
        $ReservationID = $this->getReservationID($CustomerName);
        
        $PaymentID = DB::table('tblPayment')->pluck('strPaymentID')->first();
        if(!$PaymentID){
            $PaymentID = "PYMT1";
        }
        else{
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
        }
        
        $PaymentRemarks = collect(['RentedItemID' => $RentedItemID]);

        $jsonRemarks = $PaymentRemarks->toJson();
        
        $TransactionData = array('strPaymentID'=>$PaymentID,
                              'strPayReservationID'=>$ReservationID,
                              'dblPayAmount'=>$RentTotal,
                              'strPayTypeID'=> 11,
                              'dtePayDate'=>$DateToday,
                              'strPaymentRemarks'=>$jsonRemarks);
        
        DB::table('tblPayment')->insert($TransactionData);
        
        \Session::flash('flash_message','Successfully rented the item!');
        
        return redirect('ItemRental');
    }
    
    //rent item with payment
    public function storeRentalItemPayment(Request $req){
        $ItemID = trim($req->input('RentPayItemID'));
        $CustomerName = trim($req->input('RentPayGuest'));
        $RentQuantity = trim($req->input('RentPayQuantity'));
        $RentDuration = trim($req->input('RentPayDuration'));
        $RentTotal = trim($req->input('RentPayTotal'));
        $PaymentStatus = 1;
        
        $RentedItemID = $this->saveRentalItem($ItemID, $CustomerName, $RentQuantity, $RentDuration, $PaymentStatus);
        $ReservationID = $this->getReservationID($CustomerName);
        
        $DateToday = Carbon::now()->toDateString();
        
        $PaymentID = DB::table('tblPayment')->pluck('strPaymentID')->first();
        if(!$PaymentID){
            $PaymentID = "PYMT1";
        }
        else{
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
        }
        
        $PaymentRemarks = collect(['RentedItemID' => $RentedItemID]);

        $jsonRemarks = $PaymentRemarks->toJson();
        
        $TransactionData = array('strPaymentID'=>$PaymentID,
                              'strPayReservationID'=>$ReservationID,
                              'dblPayAmount'=>$RentTotal,
                              'strPayTypeID'=> 12,
                              'dtePayDate'=>$DateToday,
                              'strPaymentRemarks'=>$jsonRemarks);
        
        DB::table('tblPayment')->insert($TransactionData);
        
        \Session::flash('flash_message','Successfully rented the item!');
        
        return redirect('ItemRental');
    }
    
    //rent item with package
    public function storeRentalItemPackage(Request $req){
        $PaymentStatus = 3;
        $DateToday = Carbon::now()->toDateString();
        $ReservationID = trim($req->input('RentPackageReservationID'));
        $ItemID = trim($req->input('RentPackageItemID'));
        $RentQuantity = trim($req->input('RentPackageQuantity'));
        $RentDuration = trim($req->input('RentPackageDuration'));
        $CustomerName = trim($req->input('RentPackageCustomerName'));
      
        $RentedItemID = $this->saveRentalItem($ItemID, $CustomerName, $RentQuantity, $RentDuration, $PaymentStatus);
        
        $PaymentID = DB::table('tblPayment')->pluck('strPaymentID')->first();
        if(!$PaymentID){
            $PaymentID = "PYMT1";
        }
        else{
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
        }
        
        $TransactionData = array('strPaymentID'=>$PaymentID,
                              'strPayReservationID'=>$ReservationID,
                              'dblPayAmount'=>0,
                              'strPayTypeID'=> 26,
                              'dtePayDate'=>$DateToday,
                              'strPaymentRemarks'=>$RentedItemID);
        
        DB::table('tblPayment')->insert($TransactionData);
        
        \Session::flash('flash_message','Successfully rented the item!');
        
        return redirect('ItemRental');
    }
    
    //save rental item to db
    public function saveRentalItem($ItemID, $CustomerName, $RentQuantity, $RentDuration, $PaymentStatus){
        $ReservationID = $this->getReservationID($CustomerName);
        $RentedItems = DB::table('tblrenteditem')->get();
    
        $RentItemID;
        if(sizeof($RentedItems) == 0){
            $RentItemID = "RENT1";
        }
        else{
            $RentItemID = $this->SmartCounter('tblrenteditem', 'strRentedItemID');
        }
        
        $dt = Carbon::now('HongKong');
        $TimeToday = $dt->toTimeString(); 
        $DateToday = $dt->toDateString();
        $TimeRented = $DateToday." ".$TimeToday;
        //save Rented item
        
        $data = array('strRentedItemID'=>$RentItemID,
                     'strRentedIReservationID'=>$ReservationID,
                     'strRentedIItemID'=>$ItemID,
                     'intRentedIReturned'=>0,
                     'intRentedIQuantity'=>$RentQuantity,
                     'intRentedIDuration'=>$RentDuration,
                     'intRentedIBroken'=>0,
                     'intRentedIPayment'=>$PaymentStatus,
                     'intRentedIBrokenQuantity'=>0,
                     'tmsCreated'=>$TimeRented);
        
        DB::table('tblRentedItem')->insert($data);
        
        return $RentItemID;
    }
    
    //return item
    public function storeReturnItem(Request $req){
  
        $DateTimeToday = Carbon::now('HongKong')->format('Y-m-d');
        $ItemID = trim($req->input('ReturnItemID'));
        $ReservationID = trim($req->input('ReturnReservationID'));
        $RentedItemID = trim($req->input('ReturnRentedItemID'));
        $ItemRate = trim($req->input('ReturnItemRate'));
        $ItemQuantity = trim($req->input('ReturnTotalQuantity'));
        $ItemName = trim($req->input('ReturnItemName'));
        $CustomerName = trim($req->input('ReturnGuestName'));
        $TimePenalty = trim($req->input('ReturnTimePenalty'));
        $RentalStatus = trim($req->input('ReturnRentalStatus'));
        $ExcessTime = trim($req->input('ReturnExcessTime'));
        $QuantityReturned = trim($req->input('ReturnQuantityAvailed'));
        $ItemStatus = trim($req->input('ReturnItemStatus'));
        $BrokenQuantity = trim($req->input('ReturnBrokenQuantity'));
        $BrokenPenalty = trim($req->input('ReturnBrokenPenalty'));
        $PaymentStatus = 0;
        
        $this->saveReturnItem($DateTimeToday, $ItemID, $ReservationID, $RentedItemID, $ItemRate, $ItemQuantity, $TimePenalty, $RentalStatus, $ExcessTime, $QuantityReturned, $ItemStatus, $BrokenQuantity, $BrokenPenalty, $PaymentStatus, $ItemName);
        
        \Session::flash('flash_message','Successfully returned the item!');
        
        return redirect('ItemRental');
    }
    
    //return item with payment
    public function storeReturnItemPayment(Request $req){
        $DateTimeToday = Carbon::now('HongKong')->format('Y-m-d');
        $ItemID = trim($req->input('ReturnPayItemID'));
        $ReservationID = trim($req->input('ReturnPayReservationID'));
        $RentedItemID = trim($req->input('ReturnPayRentedItemID'));
        $ItemRate = trim($req->input('ReturnPayItemRate'));
        $ItemQuantity = trim($req->input('ReturnPayTotalQuantity'));
        $ItemName = trim($req->input('ReturnPayItemName'));
        $CustomerName = trim($req->input('ReturnPayGuestName'));
        $TimePenalty = trim($req->input('ReturnPayTimePenalty'));
        $RentalStatus = trim($req->input('ReturnPayRentalStatus'));
        $ExcessTime = trim($req->input('ReturnPayExcessTime'));
        $QuantityReturned = trim($req->input('ReturnPayQuantityAvailed'));
        $ItemStatus = trim($req->input('ReturnPayItemStatus'));
        $BrokenQuantity = trim($req->input('ReturnPayBrokenQuantity'));
        $BrokenPenalty = trim($req->input('ReturnPayBrokenPenalty'));
        $PaymentStatus = 1;
        
        $this->saveReturnItem($DateTimeToday, $ItemID, $ReservationID, $RentedItemID, $ItemRate, $ItemQuantity, $TimePenalty, $RentalStatus, $ExcessTime, $QuantityReturned, $ItemStatus, $BrokenQuantity, $BrokenPenalty, $PaymentStatus, $ItemName);
        
        \Session::flash('flash_message','Successfully returned the item!');
        
        return redirect('ItemRental');
    }
    
    //save returned item to db
    public function saveReturnItem($DateTimeToday, $ItemID, $ReservationID, $RentedItemID, $ItemRate, $ItemQuantity, $TimePenalty, $RentalStatus, $ExcessTime, $QuantityReturned, $ItemStatus, $BrokenQuantity, $BrokenPenalty, $PaymentStatus, $ItemName){
        
        $QuantityLeft = (int)$ItemQuantity - (int)$QuantityReturned;
        
        if($ItemStatus == "Good"){
            if($ItemQuantity == $QuantityReturned){
                $updateData = array("intRentedIReturned" => "1");   
        
                DB::table('tblRentedItem')
                    ->where('strRentedItemID', '=', $RentedItemID)
                    ->update($updateData);
            }
            else{
                $updateData = array("intRentedIReturned" => "1",
                                        "intRentedIQuantity" => $QuantityReturned);   
            
                $RentalInfo = DB::table('tblRentedItem')
                ->where('strRentedItemID', '=', $RentedItemID)
                ->get();

                DB::table('tblRentedItem')
                    ->where('strRentedItemID', '=', $RentedItemID)
                    ->update($updateData);
                
                $newRentItemID = $this->SmartCounter('tblrenteditem', 'strRentedItemID');
                foreach($RentalInfo as $Item){
                    $data = array('strRentedItemID'=>$newRentItemID,
                             'strRentedIReservationID'=>$ReservationID,
                             'strRentedIItemID'=>$ItemID,
                             'intRentedIReturned'=>0,
                             'intRentedIQuantity'=>$QuantityLeft,
                             'intRentedIDuration'=>$Item->intRentedIDuration,
                             'intRentedIBroken'=>0,
                             'intRentedIPayment'=>$Item->intRentedIPayment,
                             'intRentedIBrokenQuantity'=>0,
                             'tmsCreated'=>$Item->tmsCreated);

                    DB::table('tblRentedItem')->insert($data);
                }
            }
            
            if((int)$TimePenalty != "0"){
                    
                $PaymentDescription = "Excess time is:".$ExcessTime;
                $PaymentRemarks = collect(['QuantityReturned' => $QuantityReturned, 'TimePenalty' => $TimePenalty, 'Description'=>$PaymentDescription, 'ItemID' => $ItemID, 'ItemName' => $ItemName, 'RentedItemID' => $RentedItemID]);

                $jsonRemarks = $PaymentRemarks->toJson();

                if($PaymentStatus == 1){
                    $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
                    $data = array('strPaymentID'=>$PaymentID,
                             'strPayReservationID'=>$ReservationID,
                             'dblPayAmount'=>$TimePenalty,
                             'strPayTypeID'=>13,
                             'dtePayDate'=>$DateTimeToday,
                             'strPaymentRemarks'=>$jsonRemarks);

                    DB::table('tblPayment')->insert($data);
                }
                else{
                    $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');

                    $data = array('strPaymentID'=>$PaymentID,
                                 'strPayReservationID'=>$ReservationID,
                                 'dblPayAmount'=>$TimePenalty,
                                 'strPayTypeID'=>6,
                                 'dtePayDate'=>$DateTimeToday,
                                 'strPaymentRemarks'=>$jsonRemarks);

                    DB::table('tblPayment')->insert($data);
                }
                
            }
        }
        else{//if item is broken 
            if($ItemQuantity == $QuantityReturned){
                $updateData = array("intRentedIReturned" => "1",
                                    "intRentedIBroken" => "1",
                                    "intRentedIBrokenQuantity" => $BrokenQuantity);   
        
                DB::table('tblRentedItem')
                    ->where('strRentedItemID', '=', $RentedItemID)
                    ->update($updateData);
            }
            else{
                $updateData = array("intRentedIReturned" => "1",
                                    "intRentedIQuantity" => $QuantityReturned,
                                    "intRentedIBroken" => "1",
                                    "intRentedIBrokenQuantity" => $BrokenQuantity);   
            
                $RentalInfo = DB::table('tblRentedItem')
                ->where('strRentedItemID', '=', $RentedItemID)
                ->get();

                DB::table('tblRentedItem')
                    ->where('strRentedItemID', '=', $RentedItemID)
                    ->update($updateData);

                $newRentItemID = $this->SmartCounter('tblrenteditem', 'strRentedItemID');

                foreach($RentalInfo as $Item){
                    $data = array('strRentedItemID'=>$newRentItemID,
                             'strRentedIReservationID'=>$ReservationID,
                             'strRentedIItemID'=>$ItemID,
                             'intRentedIReturned'=>0,
                             'intRentedIQuantity'=>$QuantityLeft,
                             'intRentedIDuration'=>$Item->intRentedIDuration,
                             'intRentedIBroken'=>0,
                             'intRentedIPayment'=>$Item->intRentedIPayment,
                             'intRentedIBrokenQuantity'=>0,
                             'tmsCreated'=>$Item->tmsCreated);

                    DB::table('tblRentedItem')->insert($data);
                }
            }
            
            if((int)$TimePenalty != "0"){
                    
                $PaymentDescription = "Excess time is:".$ExcessTime;
                $PaymentRemarks = collect(['QuantityReturned' => $QuantityReturned, 'TimePenalty' => $TimePenalty, 'Description'=>$PaymentDescription, 'ItemID' => $ItemID, 'ItemName' => $ItemName, 'RentedItemID' => $RentedItemID]);

                $jsonRemarks = $PaymentRemarks->toJson();

                if($PaymentStatus == 1){
                    $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
                    $data = array('strPaymentID'=>$PaymentID,
                             'strPayReservationID'=>$ReservationID,
                             'dblPayAmount'=>$TimePenalty,
                             'strPayTypeID'=>13,
                             'dtePayDate'=>$DateTimeToday,
                             'strPaymentRemarks'=>$jsonRemarks);

                    DB::table('tblPayment')->insert($data);
                }
                else{
                    $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');

                    $data = array('strPaymentID'=>$PaymentID,
                                 'strPayReservationID'=>$ReservationID,
                                 'dblPayAmount'=>$TimePenalty,
                                 'strPayTypeID'=>6,
                                 'dtePayDate'=>$DateTimeToday,
                                 'strPaymentRemarks'=>$jsonRemarks);

                    DB::table('tblPayment')->insert($data);
                }
            }
            
            if((int)$BrokenPenalty != "0"){
                $PaymentDescription = "Number of broken/lost item is ".$BrokenQuantity;
                $PaymentRemarks = collect(['Description'=>$PaymentDescription, 'ItemID' => $ItemID, 'ItemName' => $ItemName, 'RentedItemID' => $RentedItemID]);

                $jsonRemarks = $PaymentRemarks->toJson();

                if($PaymentStatus == 1){
                    $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
                    $data = array('strPaymentID'=>$PaymentID,
                             'strPayReservationID'=>$ReservationID,
                             'dblPayAmount'=>$BrokenPenalty,
                             'strPayTypeID'=>14,
                             'dtePayDate'=>$DateTimeToday,
                             'strPaymentRemarks'=>$jsonRemarks);

                    DB::table('tblPayment')->insert($data);
                }
                else{
                    $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');

                    $data = array('strPaymentID'=>$PaymentID,
                                 'strPayReservationID'=>$ReservationID,
                                 'dblPayAmount'=>$BrokenPenalty,
                                 'strPayTypeID'=>7,
                                 'dtePayDate'=>$DateTimeToday,
                                 'strPaymentRemarks'=>$jsonRemarks);

                    DB::table('tblPayment')->insert($data);
                }
            }
        }
    }
    
    
    //restore item
    public function storeRestoreItem(Request $req){
        $ItemID = trim($req->input('BrokenItemID'));
        $ReservationID = trim($req->input('BrokenReservationID'));
        $RentedItemID = trim($req->input('BrokenRentedItemID'));
        $ItemQuantity = trim($req->input('BrokenItemQuantity'));
        $RestoreQuantity = trim($req->input('BrokenRestoreQuantity'));
        
        $NewBrokenQuantity = (int)$ItemQuantity - (int)$RestoreQuantity;
        
        $updateData = array("intRentedIBrokenQuantity" => $NewBrokenQuantity);   

        DB::table('tblRentedItem')
            ->where('strRentedItemID', '=', $RentedItemID)
            ->update($updateData);
        
        
        
        \Session::flash('flash_message','Successfully restored the item!');
        
        return redirect('ItemRental');
    }
    
    //delete
    public function DeleteItemRental(Request $req){
        $ItemID = trim($req->input('DeleteItemID'));
        $ReservationID = trim($req->input('DeleteReservationID'));
        $RentedItemID = trim($req->input('DeleteRentedItemID'));
        $TotalBrokenQuantity = trim($req->input('DeleteItemQuantity'));
        $DeleteQuantity = trim($req->input('DeleteQuantity'));
        
        $ItemQuantity = DB::table('tblItem')->where('strItemID', '=', $ItemID)->pluck('intItemQuantity')->first();
        
        $NewBrokenQuantity = (int)$TotalBrokenQuantity - (int)$DeleteQuantity;
        
        $NewItemQuantity = (int)$ItemQuantity - (int)$DeleteQuantity;
        
        $updateData = array("intRentedIBrokenQuantity" => $NewBrokenQuantity);   

        DB::table('tblRentedItem')
            ->where('strRentedItemID', '=', $RentedItemID)
            ->update($updateData);
        
        $updateItemData = array("intItemQuantity" => $NewItemQuantity);
        
        DB::table('tblItem')
            ->where('strItemID', '=', $ItemID)
            ->update($updateItemData);
        
        \Session::flash('flash_message','Successfully deleted the item!');
        
        return redirect('ItemRental');
    }
    
    //extend
    public function ExtendItemRental(Request $req){
        $ItemID = trim($req->input('ExtendItemID'));
        $ReservationID = trim($req->input('ExtendReservationID'));
        $RentedItemID = trim($req->input('ExtendRentedItemID'));
        $TotalRentedQuantity = trim($req->input('ExtendTotalQuantity'));
        $ExtendQuantity = trim($req->input('ExtendQuantity'));
        $ExtendTime = trim($req->input('ExtendTime'));
        $ExtendPrice = trim($req->input('ExtendPrice'));
        $PaymentStatus = 0;
        
        $this->saveExtendItem($ItemID, $ReservationID, $RentedItemID, $TotalRentedQuantity, $ExtendQuantity, $ExtendTime, $ExtendPrice, $PaymentStatus);
        
        \Session::flash('flash_message','Successfully extended!');
        
        return redirect('ItemRental');
    }
    
    public function ExtendItemRentalPayment(Request $req){   
        $ItemID = trim($req->input('ExtendPayItemID'));
        $ReservationID = trim($req->input('ExtendPayReservationID'));
        $RentedItemID = trim($req->input('ExtendPayRentedItemID'));
        $TotalRentedQuantity = trim($req->input('ExtendPayTotalQuantity'));
        $ExtendQuantity = trim($req->input('ExtendPayQuantity'));
        $ExtendTime = trim($req->input('ExtendPayTime'));
        $ExtendPrice = trim($req->input('ExtendPayTotal'));
        $PaymentStatus = 1;
        
        $this->saveExtendItem($ItemID, $ReservationID, $RentedItemID, $TotalRentedQuantity, $ExtendQuantity, $ExtendTime, $ExtendPrice, $PaymentStatus);
        
        \Session::flash('flash_message','Successfully extended!');
        
        return redirect('ItemRental');
    }
    
    public function saveExtendItem($ItemID, $ReservationID, $RentedItemID, $TotalRentedQuantity, $ExtendQuantity, $ExtendTime, $ExtendPrice, $PaymentStatus){

        $DateTimeToday = Carbon::now('HongKong')->format('Y-m-d');
        $RentedDuration = DB::table('tblRentedItem')->where('strRentedItemID', '=', $RentedItemID)->pluck("intRentedIDuration")->first();
        $RentTime = DB::table('tblRentedItem')->where('strRentedItemID', '=', $RentedItemID)->pluck("tmsCreated")->first();
        
        $ItemName = DB::table('tblItem')->where('strItemID', '=', $ItemID)->pluck('strItemName')->first();
        
        $QuantityDiff = (int)$TotalRentedQuantity - (int)$ExtendQuantity;
        
        if($TotalRentedQuantity == $ExtendQuantity){
            $updateData = array("intRentedIDuration" => (int)$RentedDuration + (int)$ExtendTime,
                                "tmsCreated" => $RentTime);   

            DB::table('tblRentedItem')
                ->where('strRentedItemID', '=', $RentedItemID)
                ->update($updateData);
        }
        else{
            $updateData = array("intRentedIQuantity" => $QuantityDiff,
                                "tmsCreated" => $RentTime);   

            $RentalInfo = DB::table('tblRentedItem')
            ->where('strRentedItemID', '=', $RentedItemID)
            ->get();

            DB::table('tblRentedItem')
                ->where('strRentedItemID', '=', $RentedItemID)
                ->update($updateData);

            $newRentItemID = $this->SmartCounter('tblrenteditem', 'strRentedItemID');

            foreach($RentalInfo as $Item){
                $data = array('strRentedItemID'=>$newRentItemID,
                         'strRentedIReservationID'=>$ReservationID,
                         'strRentedIItemID'=>$ItemID,
                         'intRentedIReturned'=>0,
                         'intRentedIQuantity'=>$ExtendQuantity,
                         'intRentedIDuration'=>(int)$RentedDuration + (int)$ExtendTime,
                         'intRentedIBroken'=>0,
                         'intRentedIPayment'=>$Item->intRentedIPayment,
                         'intRentedIBrokenQuantity'=>0,
                         'tmsCreated'=>$Item->tmsCreated);

                DB::table('tblRentedItem')->insert($data);
            }
        }
        
        $PaymentDescription = "Extend time is:".$ExtendTime;
        

        if($PaymentStatus == 1){
            $PaymentRemarks = collect(['ExtendQuantity' => $ExtendQuantity, 'ExtendTime'=>$ExtendTime, 'ItemID' => $ItemID, 'ItemName' => $ItemName, 'RentedItemID' => $RentedItemID]);

            $jsonRemarks = $PaymentRemarks->toJson();
            
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');

            $data = array('strPaymentID'=>$PaymentID,
                         'strPayReservationID'=>$ReservationID,
                         'dblPayAmount'=>$ExtendPrice,
                         'strPayTypeID'=>15,
                         'dtePayDate'=>$DateTimeToday,
                         'strPaymentRemarks'=>$RentedItemID);

            DB::table('tblPayment')->insert($data);
        }
        else{
            $PaymentRemarks = collect(['ExtendQuantity' => $ExtendQuantity, 'ExtendTime'=>$ExtendTime, 'ItemID' => $ItemID, 'ItemName' => $ItemName, 'RentedItemID' => $RentedItemID]);

            $jsonRemarks = $PaymentRemarks->toJson();

            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');

            $data = array('strPaymentID'=>$PaymentID,
                         'strPayReservationID'=>$ReservationID,
                         'dblPayAmount'=>$ExtendPrice,
                         'strPayTypeID'=>10,
                         'dtePayDate'=>$DateTimeToday,
                         'strPaymentRemarks'=>$jsonRemarks);

            DB::table('tblPayment')->insert($data);
        }
    }
    
    
    /*----------- MISC ----------------*/
    
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
    
    public function SmartCounter2($strTableName, $strColumnName){
        $endLoop = false;
        $latestID = DB::table($strTableName)->pluck($strColumnName)->first();
        
        $SmartCounter = $this->getID2($latestID);
        
        do{
            $DuplicateError = DB::table($strTableName)->where($strColumnName, $SmartCounter)->pluck($strColumnName)->first();
            if($DuplicateError == null){
                $endLoop = true;
            }
            else{
                $SmartCounter = $this->getID2($SmartCounter);
            }       
        }while($endLoop == false);
        
        return $SmartCounter;
    }
    
    public function getID2($latestID){
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
    
    public function getReservationID($CustomerName){
        $ReservationID = DB::table('tblReservationDetail as a')
                        ->join ('tblCustomer as b', 'a.strResDCustomerID', '=' , 'b.strCustomerID')
                        ->where([['a.intResDStatus', '=', '4'],[DB::raw('CONCAT(b.strCustFirstName , " " , b.strCustLastName)'),'=',$CustomerName]])
                        ->pluck('a.strReservationID')
                        ->first();
        
        return $ReservationID;
    }
    
    
    /*------------ ACTIVITY ------------*/
    
    //avail activity
    public function AvailActivity(Request $req){
        $DateTimeToday = Carbon::now('Asia/Manila');
        $ActivityID = trim($req->input('AvailActivityID'));
        $CustomerName = trim($req->input('AvailCustomerName'));
        $ActivityType = trim($req->input('AvailActivityType'));
        $ActivityPrice = trim($req->input('AvailActivityTotalPrice'));
        $HoursToAdd = trim($req->input('DurationTime'));
        $MinutesToAdd = trim($req->input('DurationMinute'));
        $AvailQuantity = trim($req->input('AvailLandQuantity'));
        
        $BoatName = trim($req->input('AvailBoat'));
        $ReservationID = DB::table('tblReservationDetail as a')
                        ->join ('tblCustomer as b', 'a.strResDCustomerID', '=' , 'b.strCustomerID')
                        ->where([['a.intResDStatus', '=', '4'],[DB::raw('CONCAT(b.strCustFirstName , " " , b.strCustLastName)'),'=',$CustomerName]])
                        ->pluck('a.strReservationID')
                        ->first();
        $PaymentStatus = 0;
        
        $this->saveAvailedActivity($DateTimeToday, $ActivityID, $ActivityType, $ReservationID, $PaymentStatus, $ActivityPrice, $HoursToAdd, $MinutesToAdd, $BoatName, $AvailQuantity);
        
        \Session::flash('flash_message','Successfully availed the beach activity!');
        
        return redirect('/Activities');
    }
    
    //avail activity with payment
    public function AvailActivityPayment(Request $req){
        $DateTimeToday = Carbon::now('Asia/Manila');
        $ActivityID = trim($req->input('PayActivityID'));
        $CustomerName = trim($req->input('PayReservationID'));
        $ActivityType = trim($req->input('PayActivityType'));
        $ActivityPrice = trim($req->input('ActivityTotalPrice'));
        $HoursToAdd = trim($req->input('PayDurationTime'));
        $MinutesToAdd = trim($req->input('PayDurationMinute'));
        $BoatName = trim($req->input('PayAvailBoat'));
        $AvailQuantity = trim($req->input('PayLandQuantity'));
        
        $ReservationID = DB::table('tblReservationDetail as a')
                        ->join ('tblCustomer as b', 'a.strResDCustomerID', '=' , 'b.strCustomerID')
                        ->where([['a.intResDStatus', '=', '4'],[DB::raw('CONCAT(b.strCustFirstName , " " , b.strCustLastName)'),'=',$CustomerName]])
                        ->pluck('a.strReservationID')
                        ->first();
        

        $PaymentStatus = 1;
        
        $this->saveAvailedActivity($DateTimeToday, $ActivityID, $ActivityType, $ReservationID, $PaymentStatus, $ActivityPrice, $HoursToAdd, $MinutesToAdd, $BoatName, $AvailQuantity);
        
        \Session::flash('flash_message','Successfully availed the beach activity!');
        
        return redirect('/Activities');
    }
    
    //avail activity with package
    public function AvailActivityPackage(Request $req){
        $DateToday = Carbon::now()->toDateString();
        $DateTimeToday = Carbon::now('Asia/Manila');
        $ReservationID = trim($req->input('PackageReservationID'));
        $ActivityID = trim($req->input('PackageActivityID'));
        $ActivityType = trim($req->input('PackageActivityType'));
        $QuantityIncluded = trim($req->input('PackageQuantityIncluded'));
        $AvailQuantity = trim($req->input('PackageGuestQuantity'));
        $BoatName = trim($req->input('PackageAvailBoat'));
        $HoursToAdd = trim($req->input('PackageDurationTime'));
        $MinutesToAdd = trim($req->input('PackageDurationMinute'));

        $AvailedActivities = DB::table('tblavailbeachactivity')->get();
        $PaymentStatus = 1;
        if((sizeof($AvailedActivities) == 0)){
            $AvailActivityID = "BAVL1";
        }
        else{
            $AvailActivityID = $this->SmartCounter('tblavailbeachactivity', 'strAvailBeachActivityID');
        }
        
        if($ActivityType != 1){
            $data = array('strAvailBeachActivityID'=>$AvailActivityID,
                     'strAvailBAReservationID'=>$ReservationID,
                     'strAvailBABeachActivityID'=>$ActivityID,
                     'strAvailBABoatID'=> null,
                     'intAvailBAQuantity'=>$AvailQuantity,
                     'intAvailBAPayment'=>$PaymentStatus,
                     'tmsCreated'=>$DateTimeToday);
        
            DB::table('tblavailbeachactivity')->insert($data);
            
        }
        else{
            $DropOff = Carbon::now('Asia/Manila');
    
            if($HoursToAdd != "0"){
                $DropOff = $DropOff->addHours((int)$HoursToAdd);
            }

            $DropOff = $DropOff->addMinutes($MinutesToAdd);
            $DropOff = $DropOff->toDateTimeString();
     
            
            $BoatSchedID = DB::table('tblBoatSchedule')->pluck('strBoatScheduleID')->first();
            if(!$BoatSchedID){
                $BoatSchedID = "BSCHD1";
            }
            else{
                $BoatSchedID = $this->SmartCounter2('tblBoatSchedule', 'strBoatScheduleID');
            }
            
            $BoatID = DB::table('tblBoat')->where([['strBoatStatus', '=', 'Available'],['strBoatName', '=', $BoatName]])->pluck('strBoatID')->first();
            
            $data = array('strAvailBeachActivityID'=>$AvailActivityID,
                     'strAvailBAReservationID'=>$ReservationID,
                     'strAvailBABeachActivityID'=>$ActivityID,
                     'strAvailBABoatID'=> $BoatID,
                     'intAvailBAQuantity'=>1,
                     'intAvailBAPayment'=>$PaymentStatus,
                     'tmsCreated'=>$DateTimeToday);
        
            DB::table('tblavailbeachactivity')->insert($data);
            
            $InsertBoatSchedData = array('strBoatScheduleID'=>$BoatSchedID,
                                         'strBoatSBoatID'=>$BoatID,
                                         'strBoatSPurpose'=>'Beach Activity',
                                         'dtmBoatSPickUp'=>$DateTimeToday,
                                         'dtmBoatSDropOff'=>$DropOff,
                                         'intBoatSStatus'=>'1',
                                         'strBoatSReservationID' => $ReservationID);
            
            DB::table('tblboatschedule')->insert($InsertBoatSchedData);
        }
        
        $PaymentID = DB::table('tblPayment')->pluck('strPaymentID')->first();
        if(!$PaymentID){
            $PaymentID = "PYMT1";
        }
        else{
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
        }
        
        $TransactionData = array('strPaymentID'=>$PaymentID,
                              'strPayReservationID'=>$ReservationID,
                              'dblPayAmount'=>0,
                              'strPayTypeID'=> 27,
                              'dtePayDate'=>$DateToday,
                              'strPaymentRemarks'=>$AvailActivityID);
        
        DB::table('tblPayment')->insert($TransactionData);
        
        \Session::flash('flash_message','Successfully availed the beach activity!');
        
        return redirect('/Activities');
    }
    
    //save availed activity to db
    public function saveAvailedActivity($DateTimeToday, $ActivityID, $ActivityType, $ReservationID, $PaymentStatus, $ActivityPrice, $HoursToAdd, $MinutesToAdd, $BoatName, $AvailQuantity){
        $AvailedActivities = DB::table('tblavailbeachactivity')->get();
            
        if((sizeof($AvailedActivities) == 0)){
            $AvailActivityID = "BAVL1";
        }
        else{
            $AvailActivityID = $this->SmartCounter('tblavailbeachactivity', 'strAvailBeachActivityID');
        }
    
        if($ActivityType == "Land"){   
            
            
            $data = array('strAvailBeachActivityID'=>$AvailActivityID,
                     'strAvailBAReservationID'=>$ReservationID,
                     'strAvailBABeachActivityID'=>$ActivityID,
                     'strAvailBABoatID'=> null,
                     'intAvailBAQuantity'=>$AvailQuantity,
                     'intAvailBAPayment'=>$PaymentStatus,
                     'tmsCreated'=>$DateTimeToday,
                     'intBeachAFinished' => 1);
        
            DB::table('tblavailbeachactivity')->insert($data);
            
        }
        else if($ActivityType == "Water"){

            $DropOff = Carbon::now('Asia/Manila');
    
            if($HoursToAdd != "0"){
                $DropOff = $DropOff->addHours((int)$HoursToAdd);
            }

            $DropOff = $DropOff->addMinutes($MinutesToAdd);
            $DropOff = $DropOff->toDateTimeString();
     
            
            $BoatSchedID = DB::table('tblBoatSchedule')->pluck('strBoatScheduleID')->first();
            if(!$BoatSchedID){
                $BoatSchedID = "BSCHD1";
            }
            else{
                $BoatSchedID = $this->SmartCounter2('tblBoatSchedule', 'strBoatScheduleID');
            }
            
            $BoatID = DB::table('tblBoat')->where([['strBoatStatus', '=', 'Available'],['strBoatName', '=', $BoatName]])->pluck('strBoatID')->first();
            
            $data = array('strAvailBeachActivityID'=>$AvailActivityID,
                     'strAvailBAReservationID'=>$ReservationID,
                     'strAvailBABeachActivityID'=>$ActivityID,
                     'strAvailBABoatID'=> $BoatID,
                     'intAvailBAQuantity'=>1,
                     'intAvailBAPayment'=>$PaymentStatus,
                     'tmsCreated'=>$DateTimeToday);
        
            DB::table('tblavailbeachactivity')->insert($data);
            
            $InsertBoatSchedData = array('strBoatScheduleID'=>$BoatSchedID,
                                         'strBoatSBoatID'=>$BoatID,
                                         'strBoatSPurpose'=>'Beach Activity',
                                         'dtmBoatSPickUp'=>$DateTimeToday,
                                         'dtmBoatSDropOff'=>$DropOff,
                                         'intBoatSStatus'=>'1',
                                         'strBoatSReservationID' => $ReservationID,
                                         'intBoatSPayment' => 2);
            
            DB::table('tblboatschedule')->insert($InsertBoatSchedData);
        }
        
        $PaymentRemarks = collect(['AvailActivityID' => $AvailActivityID]);

        $jsonRemarks = $PaymentRemarks->toJson();
        
        if($PaymentStatus == 1){
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');

            $data = array('strPaymentID'=>$PaymentID,
                         'strPayReservationID'=>$ReservationID,
                         'dblPayAmount'=>$ActivityPrice,
                         'strPayTypeID'=>17,
                         'dtePayDate'=>$DateTimeToday,
                         'strPaymentRemarks'=>$jsonRemarks);

            DB::table('tblPayment')->insert($data);
        }
        else{
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');

            $data = array('strPaymentID'=>$PaymentID,
                         'strPayReservationID'=>$ReservationID,
                         'dblPayAmount'=>$ActivityPrice,
                         'strPayTypeID'=>16,
                         'dtePayDate'=>$DateTimeToday,
                         'strPaymentRemarks'=>$jsonRemarks);

            DB::table('tblPayment')->insert($data);
        }
    }
    
    //activity done
    public function ActivityDone(Request $req){
        $BoatSchedID = trim($req->input('DoneBoatSchedID'));
        $AvailID = trim($req->input('DoneAvailID'));
        $updateData = array("intBoatSStatus" => "0");   

        DB::table('tblBoatSchedule')
            ->where('strBoatScheduleID', '=', $BoatSchedID)
            ->update($updateData);

        $updateData2 = array("intBeachAFinished" => 1);

        DB::table('tblavailbeachactivity')
            ->where('strAvailBeachActivityID', '=', $AvailID)
            ->update($updateData2);
        
        \Session::flash('flash_message','Successfully availed the beach activity!');
        
        return redirect('/Activities');
    }
    
     /*-------------- FEE -------------*/

    public function AddFee(Request $req){
        $ReservationID = trim($req->input('AddReservationID'));
        $FeeID = trim($req->input('AddFeeID'));
        $FeeQuantity = trim($req->input('AddFeeQuantity'));
        
        $FeeAmount = DB::table('tblFee as a')
                ->join ('tblFeeAmount as b', 'a.strFeeID', '=' , 'b.strFeeID')
                ->where([['b.dtmFeeAmountAsOf',"=", DB::raw("(SELECT max(dtmFeeAmountAsOf) FROM tblFeeAmount WHERE strFeeID = a.strFeeID)")],['a.strFeeID', "=", $FeeID]])
                ->pluck('b.dblFeeAmount')
                ->first();
        
        $TotalPrice = $FeeQuantity * $FeeAmount;    
        $PaymentStatus = 0;

        $this->saveAvailedFee($ReservationID, $FeeID, $FeeQuantity, $TotalPrice, $PaymentStatus);
        
        \Session::flash('flash_message','Successfully added the fee to the customer!');
        return redirect('/Fees');
    }
    
    public function PayFee(Request $req){
        $ReservationID = trim($req->input('PayReservationID'));
        $FeeID = trim($req->input('PayFeeID'));
        $FeeQuantity = trim($req->input('PayFeeQuantity'));
        $TotalPrice = trim($req->input('TotalFeePrice'));
        $PaymentStatus = 1;
        
        $this->saveAvailedFee($ReservationID, $FeeID, $FeeQuantity, $TotalPrice, $PaymentStatus);
        
        \Session::flash('flash_message','Successfully added the fee to the customer!');
        return redirect('/Fees');
    }
    
    public function saveAvailedFee($ReservationID, $FeeID, $FeeQuantity, $TotalPrice, $PaymentStatus){
        $DateTimeToday = Carbon::now('HongKong')->format('Y-m-d');
        if($PaymentStatus == 0){
            $ReservedFeeQuantity = DB::table('tblReservationFee')
                ->where([['strResFReservationID', '=', $ReservationID],['intResFPayment', '=', 0], ['strResFFeeID', '=', $FeeID]])
                ->pluck('intResFQuantity')
                ->first();
        
            if($ReservedFeeQuantity != null){
                $FeeQuantity = $ReservedFeeQuantity + $FeeQuantity;

                $updateData = array("intResFQuantity" => $FeeQuantity);   

                DB::table('tblReservationFee')
                    ->where([['strResFReservationID', '=', $ReservationID], ['strResFFeeID', '=', $FeeID], ["intResFPayment", '=', '0']])
                    ->update($updateData);
            }
            else{
                $data = array('strResFReservationID'=>$ReservationID,
                                 'strResFFeeID'=>$FeeID,
                                 'intResFPayment'=>$PaymentStatus,
                                 'intResFQuantity'=> $FeeQuantity);

                DB::table('tblReservationFee')->insert($data);
            }
        }
        
        else if($PaymentStatus == 1){
            $ReservedFeeQuantity = DB::table('tblReservationFee')
                ->where([['strResFReservationID', '=', $ReservationID],['intResFPayment', '=', 1], ['strResFFeeID', '=', $FeeID]])
                ->pluck('intResFQuantity')
                ->first();
        
            if($ReservedFeeQuantity != null){
                $FeeQuantity = $ReservedFeeQuantity + $FeeQuantity;

                $updateData = array("intResFQuantity" => $FeeQuantity);   

                DB::table('tblReservationFee')
                    ->where([['strResFReservationID', '=', $ReservationID], ['strResFFeeID', '=', $FeeID], ["intResFPayment", '=', '1']])
                    ->update($updateData);
            }
            else{
                $data = array('strResFReservationID'=>$ReservationID,
                                 'strResFFeeID'=>$FeeID,
                                 'intResFPayment'=>$PaymentStatus,
                                 'intResFQuantity'=> $FeeQuantity);

                DB::table('tblReservationFee')->insert($data);
            }
        }

        if($PaymentStatus == 1){
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');

            $data = array('strPaymentID'=>$PaymentID,
                     'strPayReservationID'=>$ReservationID,
                     'dblPayAmount'=>$TotalPrice,
                     'strPayTypeID'=>19,
                     'dtePayDate'=>$DateTimeToday);

            DB::table('tblPayment')->insert($data);
        }
        else{
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');

            $data = array('strPaymentID'=>$PaymentID,
                         'strPayReservationID'=>$ReservationID,
                         'dblPayAmount'=>$TotalPrice,
                         'strPayTypeID'=>18,
                         'dtePayDate'=>$DateTimeToday);

            DB::table('tblPayment')->insert($data);
        }
    }
    
    public function EditFee(Request $req){
        $ReservationID = trim($req->input('EditReservationID'));
        $FeeID = trim($req->input('EditFeeID'));
        $FeeQuantity = trim($req->input('EditFeeQuantity'));
        
        $updateData = array("intResFQuantity" => $FeeQuantity);   

        DB::table('tblReservationFee')
            ->where([['strResFReservationID', '=', $ReservationID], ['strResFFeeID', '=', $FeeID], ["intResFPayment", '=', '0']])
            ->update($updateData);
        
        \Session::flash('flash_message','Successfully edited the fee of the customer!');
        
        return redirect('/Fees');
    }
    
    public function DeleteFee(Request $req){
        $ReservationID = trim($req->input('DeleteReservationID'));
        $FeeID = trim($req->input('DeleteFeeID'));
        DB::table('tblreservationfee')->where([['strResFReservationID', '=', $ReservationID],['strResFFeeID', '=', $FeeID],['intResFPayment', '=', 0]])->delete();
        
        \Session::flash('flash_message','Successfully deleted the fee of the customer!');
        
        return redirect('/Fees');
    }
    
    
    /*------------- CUSTOMERS -------------*/
    
    public function saveAddRooms(Request $req){
   
        $ReservationID = trim($req->input('AddReservationID'));
        $ChosenRooms = trim($req->input('AddChosenRooms'));
        $AmountPaid = trim($req->input('AddRoomAmount'));
        $tempCheckInDate = trim($req->input('AddToday'));
        $tempCheckOutDate = trim($req->input('AddDeparture'));
        $PaymentStatus = 2;
        $DateToday = Carbon::now()->toDateString();
        
        $CheckInDate = Carbon::parse($tempCheckInDate)->format('Y/m/d h:i:s');
        $CheckOutDate = Carbon::parse($tempCheckOutDate)->format('Y/m/d h:i:s');
        
        $this->saveReservedRooms($ChosenRooms, $CheckInDate, $CheckOutDate, $ReservationID, $PaymentStatus);
        
        $PaymentID = DB::table('tblPayment')->pluck('strPaymentID')->first();
        if(!$PaymentID){
            $PaymentID = "PYMT1";
        }
        else{
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
        }
        
        $PaymentRemarks = collect(['CheckInDate' => $CheckInDate, 'CheckOutDate' => $CheckOutDate, 'ChosenRooms'=>$ChosenRooms]);

        $jsonRemarks = $PaymentRemarks->toJson();
        
        $TransactionData = array('strPaymentID'=>$PaymentID,
                              'strPayReservationID'=>$ReservationID,
                              'dblPayAmount'=>$AmountPaid,
                              'strPayTypeID'=> 20,
                              'dtePayDate'=>$DateToday,
                              'strPaymentRemarks'=>$jsonRemarks);
        
        DB::table('tblPayment')->insert($TransactionData);
        
        \Session::flash('flash_message','Successfully added a room!');
        
        return redirect('/Customers');
       
    }
    
    public function saveAddRoomsPayment(Request $req){
        $ReservationID = trim($req->input('AddPayReservationID'));
        $ChosenRooms = trim($req->input('AddPayChosenRooms'));
        $AmountPaid = trim($req->input('AddPayTotal'));
        $tempCheckInDate = trim($req->input('AddPayToday'));
        $tempCheckOutDate = trim($req->input('AddPayDeparture'));
        $DateToday = Carbon::now()->toDateString();
        $CheckInDate = Carbon::parse($tempCheckInDate)->format('Y/m/d h:i:s');
        $CheckOutDate = Carbon::parse($tempCheckOutDate)->format('Y/m/d h:i:s');
   
        $PaymentStatus = 3;
        
        $this->saveReservedRooms($ChosenRooms, $CheckInDate, $CheckOutDate, $ReservationID, $PaymentStatus);
        
        $PaymentID = DB::table('tblPayment')->pluck('strPaymentID')->first();
        if(!$PaymentID){
            $PaymentID = "PYMT1";
        }
        else{
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
        }
        
        $PaymentRemarks = collect(['CheckInDate' => $CheckInDate, 'CheckOutDate' => $CheckOutDate, 'ChosenRooms'=>$ChosenRooms]);

        $jsonRemarks = $PaymentRemarks->toJson();
        
        $TransactionData = array('strPaymentID'=>$PaymentID,
                              'strPayReservationID'=>$ReservationID,
                              'dblPayAmount'=>$AmountPaid,
                              'strPayTypeID'=> 21,
                              'dtePayDate'=>$DateToday,
                              'strPaymentRemarks'=>$jsonRemarks);
        
        DB::table('tblPayment')->insert($TransactionData);
        
        \Session::flash('flash_message','Successfully added a room!');
        
        return redirect('/Customers');
    }
    
    public function saveReservedRooms($ChosenRooms, $CheckInDate, $CheckOutDate, $ReservationID, $PaymentStatus){
       
        //Prepares Room Data
        $IndividualRooms = explode(',',$ChosenRooms);
        $IndividualRoomsLength = sizeof($IndividualRooms);
        $IndividualRoomType = [];
        
        for($x = 0; $x < $IndividualRoomsLength; $x++){
            $IndividualRoomDetails = explode('-', $IndividualRooms[$x]);
            $IndividualRoomType[$x] = DB::table('tblRoomType')->where([['strRoomType',"=",$IndividualRoomDetails[0]], ['intRoomTDeleted',"=","1"]])->pluck('strRoomTypeID')->first();
        }
        
        $AvailableRooms = "";
        $IndividualRoomTypeLength = sizeof($IndividualRoomType);
         
        for($x = 0; $x < $IndividualRoomTypeLength; $x++){
            
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
                        ->join ('tblRoomRate as c', 'a.strRoomTypeID', '=' , 'c.strRoomTypeID')
                        ->select('a.strRoomID')
                         ->whereNotIn('strRoomID', $ExistingRooms)
                         ->where([['a.strRoomStatus','=','Available'],['c.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],['a.strRoomTypeID', '=', $IndividualRoomType[$x]]])
                         ->groupBy('a.strRoomID')
                         ->get();
            
            foreach($Rooms as $Room){
                $AvailableRooms .= $Room->strRoomID . ",";
            }
            
            $AvailableRooms .= "@";
        }
        
        $arrAvailableRooms = explode('@', $AvailableRooms);
        array_pop($arrAvailableRooms);
    
        //Saves Reserved Rooms
        for($x = 0; $x < $IndividualRoomTypeLength; $x++){
           $IndividualRoomsInfo = explode('-', $IndividualRooms[$x]);

           for($y = 0; $y < $IndividualRoomsInfo[3]; $y++){
               $AvailableRoomsArray = explode(',', $arrAvailableRooms[$x]);
               array_pop($AvailableRoomsArray);
               $AvailableRoomsArrayLength = sizeof($AvailableRoomsArray);

                   for($z = 0; $z <= $AvailableRoomsArrayLength; $z++){
                        if($z != $IndividualRoomsInfo[3]){
                            $InsertRoomsData = array('strResRReservationID'=>$ReservationID,
                                                     'strResRRoomID'=>$AvailableRoomsArray[$z],
                                                     'intResRPayment'=>$PaymentStatus);
                            
                            DB::table('tblReservationRoom')->insert($InsertRoomsData);
                        }
                        else{
                            break;
                        }
                    }
                break;

           }
        }
    }

    public function saveExtendStayFree(Request $req){
        $ReservationID = trim($req->input('FreeExtendReservationID'));
        $ExtendTotal = trim($req->input('FreeExtendNight'));
        $TotalAmount = 0;
        $PaymentStatus = 1;
        
        $this->updateExtendStay($ReservationID, $ExtendTotal, $TotalAmount, $PaymentStatus);

        \Session::flash('flash_message','Successfully extended the stay of the customer!');
        
        return redirect('/Customers');
    }
    
    public function saveExtendStay(Request $req){
        $ReservationID = trim($req->input('ExtendLaterReservationID'));
        $ExtendTotal = trim($req->input('ExtendLaterNight'));
        $TotalAmount = trim($req->input('ExtendLaterAmount'));
        $PaymentStatus = 0;
        
        $this->updateExtendStay($ReservationID, $ExtendTotal, $TotalAmount, $PaymentStatus);

        \Session::flash('flash_message','Successfully extended the stay of the customer!');
        
        return redirect('/Customers');
    }
    
    public function saveExtendStayPay(Request $req){
        $ReservationID = trim($req->input('ExtendNowReservationID'));
        $ExtendTotal = trim($req->input('ExtendNowNight'));
        $TotalAmount = trim($req->input('ExtendPayTotal'));
        $PaymentStatus = 1;
        
        $this->updateExtendStay($ReservationID, $ExtendTotal, $TotalAmount, $PaymentStatus);
        
        \Session::flash('flash_message','Successfully extended the stay of the customer!');
        
        return redirect('/Customers');
    }
    
    public function updateExtendStay($ReservationID, $ExtendTotal, $TotalAmount, $PaymentStatus){
        
        $tempDepartureDate = DB::table('tblreservationdetail')->where('strReservationID', '=', $ReservationID)->pluck('dtmResDDeparture')->first();
        
        $DepartureDate = Carbon::parse($tempDepartureDate)->addDays($ExtendTotal)->toDateTimeString();
        
        $updateData = array('dtmResDDeparture' => $DepartureDate);
        
        DB::table('tblReservationDetail')
                ->where('strReservationID', $ReservationID)
                ->update($updateData);
        
        $DateToday = Carbon::now('Asia/Manila')->format('Y/m/d');
        
        $PaymentID = DB::table('tblPayment')->pluck('strPaymentID')->first();
        if(!$PaymentID){
            $PaymentID = "PYMT1";
        }
        else{
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
        }

        if($PaymentStatus == 1){

            $TransactionData = array('strPaymentID'=>$PaymentID,
                                      'strPayReservationID'=>$ReservationID,
                                      'dblPayAmount'=>$TotalAmount,
                                      'strPayTypeID'=> 25,
                                      'dtePayDate'=>$DateToday,
                                      'strPaymentRemarks'=>$ExtendTotal);

            DB::table('tblPayment')->insert($TransactionData);
        }
        
        else if($PaymentStatus == 0){

            $TransactionData = array('strPaymentID'=>$PaymentID,
                                      'strPayReservationID'=>$ReservationID,
                                      'dblPayAmount'=>$TotalAmount,
                                      'strPayTypeID'=> 24,
                                      'dtePayDate'=>$DateToday,
                                      'strPaymentRemarks'=>$ExtendTotal);

            DB::table('tblPayment')->insert($TransactionData);
        }
    }
    
    public function editCustomerInfo(Request $req){
        
        $CustomerID = trim($req->input('EditCustomerID'));
        $CustFirstName = trim($req->input('CustFirstName'));
        $CustMiddleName = trim($req->input('CustMiddleName'));
        $CustLastName = trim($req->input('CustLastName'));
        $CustAddress = trim($req->input('CustAddress'));
        $CustContact = trim($req->input('CustContact'));
        $CustEmail = trim($req->input('CustEmail'));
        $CustNationality = trim($req->input('CustNationality'));
        $CustGender = trim($req->input('CustGender'));
        $CustBirthday = trim($req->input('CustBirthday'));
        
        $CustBirthday = Carbon::parse($CustBirthday)->Format('Y/m/d');
        
        if($CustGender == "Male"){
            $CustGender = "M";
        }
        else{
            $CustGender = "F";
        }
        
        $updateData = array('strCustFirstName' => $CustFirstName,
                            'strCustMiddleName' => $CustMiddleName,
                            'strCustLastName' => $CustLastName,
                            'strCustAddress' => $CustAddress,
                            'strCustContact' => $CustContact,
                            'strCustEmail' => $CustEmail,
                            'strCustNationality' => $CustNationality,
                            'strCustGender' => $CustGender,
                            'dtmCustBirthday' => $CustBirthday);
        
        DB::table('tblCustomer')
            ->where('strCustomerID', '=', $CustomerID)
            ->update($updateData);
        
        \Session::flash('flash_message','Successfully updated the customer information!');
        
        return redirect('/Customers');
    }
    
    public function deleteCustomer(Request $req){
        $CustomerID = trim($req->input('DeleteCustomerID'));
        $ExistingReservations = DB::table('tblReservationDetail as a')
                                ->join ('tblCustomer as b', 'a.strResDCustomerID','=','b.strCustomerID')
                                ->where(function($query){
                                    $query->where('intResDStatus', '=', '1')
                                          ->orWhere('intResDStatus', '=', '2')
                                          ->orWhere('intResDStatus', '=', '4');
                                })
                                ->where('b.strCustomerID','=',$CustomerID)
                                ->get();
        
        if(sizeof($ExistingReservations) == 0){
            $updateData = array('intCustStatus' => 0);
        
            DB::table('tblCustomer')
                ->where('strCustomerID', '=', $CustomerID)
                ->update($updateData);
            
            \Session::flash('flash_message','Successfully deleted!');
        
        return redirect('/Customers');
        }
        else{
            \Session::flash('duplicate_message','Cannot delete the customer because they still have an active/on going reservation');
            return redirect('/Customers');
        }
        
    }

    public function blockCustomer(Request $req){
        $CustomerID = trim($req->input('BlockCustomerID'));

        $ExistingReservations = DB::table('tblReservationDetail as a')
                                ->join ('tblCustomer as b', 'a.strResDCustomerID','=','b.strCustomerID')
                                ->where(function($query){
                                    $query->where('intResDStatus', '=', '1')
                                          ->orWhere('intResDStatus', '=', '2')
                                          ->orWhere('intResDStatus', '=', '4');
                                })
                                ->where('b.strCustomerID','=',$CustomerID)
                                ->get();
        
        if(sizeof($ExistingReservations) == 0){
            $updateData = array('intCustStatus' => 2);
        
            DB::table('tblCustomer')
                ->where('strCustomerID', '=', $CustomerID)
                ->update($updateData);
            
            \Session::flash('flash_message','Successfully blocked the customer!');
        
        return redirect('/Customers');
        }
        else{
            \Session::flash('duplicate_message','Cannot block the customer because they still have an active/on going reservation');
            return redirect('/Customers');
        }
    }

    public function restoreCustomer(Request $req){
        $CustomerID = trim($req->input('RestoreCustomerID'));

        $updateData = array('intCustStatus' => 1);
    
        DB::table('tblCustomer')
            ->where('strCustomerID', '=', $CustomerID)
            ->update($updateData);
        
        \Session::flash('flash_message','Successfully unblocked the customer!');
        
        return redirect('/Customers');
        

    }
    
    /*---------- ROOMS -------------*/
    
    //Upgrade Rooms
    
    public function saveUpgradeRoom(Request $req){

        $ReservationID = trim($req->input('ReservationID'));
        $RoomName = trim($req->input('RoomName'));
        $NewRoomName = trim($req->input('NewRoomName'));
        $AmountPaid = trim($req->input('TotalAmount'));
       
        $PaymentStatus = 0;
        
        $OriginalPaymentStatus = $this->fnSaveUpgradeRoom($ReservationID, $RoomName, $NewRoomName, $AmountPaid, $PaymentStatus);
   
        //get original room price
        $OriginalRoomPrice = DB::table('tblRoomType as a')
            ->join ('tblRoomRate as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
            ->join ('tblRoom as c', 'c.strRoomTypeID', '=', 'a.strRoomTypeID')
            ->where([['b.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],
                    ['a.intRoomTDeleted',"=", "1"]
                    ,['c.strRoomName', '=', $RoomName]])
            ->pluck('b.dblRoomRate')
            ->first();
        
        //get price of the upgraded room
        $UpgradeRoomPrice = DB::table('tblRoomType as a')
            ->join ('tblRoomRate as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
            ->select('b.dblRoomRate')
            ->join ('tblRoom as c', 'c.strRoomTypeID', '=', 'a.strRoomTypeID')
            ->where([['b.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],
                    ['a.intRoomTDeleted',"=", "1"]
                    ,['c.strRoomName', '=', $NewRoomName]])
            ->pluck('b.dblRoomRate')
            ->first();
        
        //get the reservation dates
        $ReservationDates = DB::table('tblReservationDetail')
                            ->select('dtmResDArrival',
                                     'dtmResDDeparture')
                            ->where('strReservationID', $ReservationID)
                            ->get();
        
        $ArrivalDate = "";
        $DepartureDate = "";
        
        foreach($ReservationDates as $Dates){
            $ArrivalDate = Carbon::now();
            $DepartureDate = Carbon::parse($Dates->dtmResDDeparture);
        }
        
        $daysOfStay = $DepartureDate->diffInDays($ArrivalDate);
        
        if($daysOfStay == 0){
            $daysOfStay = 1; 
        } 
        
        $DateTimeToday = Carbon::now('Asia/Manila')->format('Y/m/d h:i:s');
        $DateToday = Carbon::now('Asia/Manila')->format('Y/m/d');
        
        $PaymentID = DB::table('tblPayment')->pluck('strPaymentID')->first();
        if(!$PaymentID){
            $PaymentID = "PYMT1";
        }
        else{
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
        }
        $NewRoomID = DB::table('tblRoom')->where([['strRoomName', '=', $NewRoomName],['strRoomStatus','=','Available']])->pluck("strRoomID")->first();
        /*if($OriginalPaymentStatus == 1 || $OriginalPaymentStatus == 3  || $OriginalPaymentStatus == 7){
            
            $PaymentRemarks = collect(['DateUpgraded' => $DateTimeToday, 'ArrivalDate' => $ArrivalDate, 'DepartureDate' => $DepartureDate, 'OriginalRoom' => $RoomName, 'UpgradeRoom' => $NewRoomName, 'NewRoomID' => $NewRoomID]);

            $jsonRemarks = $PaymentRemarks->toJson();

            $TransactionData = array('strPaymentID'=>$PaymentID,
                                      'strPayReservationID'=>$ReservationID,
                                      'dblPayAmount'=>$AmountPaid,
                                      'strPayTypeID'=> 22,
                                      'dtePayDate'=>$DateToday,
                                      'strPaymentRemarks'=>$jsonRemarks);

            DB::table('tblPayment')->insert($TransactionData);
        }*/
        
        //if($OriginalPaymentStatus == 0 || $OriginalPaymentStatus == 2  || $OriginalPaymentStatus == 6){

            $PaymentRemarks = collect(['DateUpgraded' => $DateTimeToday, 'ArrivalDate' => $ArrivalDate, 'DepartureDate' => $DepartureDate, 'OriginalRoom' => $RoomName, 'UpgradeRoom' => $NewRoomName, 'NewRoomID' => $NewRoomID]);

            $jsonRemarks = $PaymentRemarks->toJson();

            $TransactionData = array('strPaymentID'=>$PaymentID,
                                      'strPayReservationID'=>$ReservationID,
                                      'dblPayAmount'=>$AmountPaid,
                                      'strPayTypeID'=> 22,
                                      'dtePayDate'=>$DateToday,
                                      'strPaymentRemarks'=>$jsonRemarks);
            
            DB::table('tblPayment')->insert($TransactionData);
        //}
        
        \Session::flash('flash_message','Successfully upgraded the room!');
        
        return redirect('/Rooms');
    }
    
    public function saveUpgradeRoomPayment(Request $req){
   
        $ReservationID = trim($req->input('PayReservationID'));
        $RoomName = trim($req->input('PayRoomName'));
        $NewRoomName = trim($req->input('PayNewRoomName'));
        $AmountPaid = trim($req->input('PayTotal'));
        $NewRoomID = DB::table('tblRoom')->where([['strRoomName', '=', $NewRoomName],['strRoomStatus','=','Available']])->pluck("strRoomID")->first();
    
        $PaymentStatus = 1;
        
        //save upgraded room to the database
        $OriginalPaymentStatus = $this->fnSaveUpgradeRoom($ReservationID, $RoomName, $NewRoomName, $AmountPaid, $PaymentStatus);
        
        //get original room price
        $OriginalRoomPrice = DB::table('tblRoomType as a')
            ->join ('tblRoomRate as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
            ->join ('tblRoom as c', 'c.strRoomTypeID', '=', 'a.strRoomTypeID')
            ->where([['b.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],
                    ['a.intRoomTDeleted',"=", "1"]
                    ,['c.strRoomName', '=', $RoomName]])
            ->pluck('b.dblRoomRate')
            ->first();
        
        //get price of the upgraded room
        $UpgradeRoomPrice = DB::table('tblRoomType as a')
            ->join ('tblRoomRate as b', 'a.strRoomTypeID', '=' , 'b.strRoomTypeID')
            ->select('b.dblRoomRate')
            ->join ('tblRoom as c', 'c.strRoomTypeID', '=', 'a.strRoomTypeID')
            ->where([['b.dtmRoomRateAsOf',"=", DB::raw("(SELECT max(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID)")],
                    ['a.intRoomTDeleted',"=", "1"]
                    ,['c.strRoomName', '=', $NewRoomName]])
            ->pluck('b.dblRoomRate')
            ->first();
        
        //get the reservation dates
        $ReservationDates = DB::table('tblReservationDetail')
                            ->select('dtmResDArrival',
                                     'dtmResDDeparture')
                            ->where('strReservationID', $ReservationID)
                            ->get();
        
        $ArrivalDate = "";
        $DepartureDate = "";
        
        foreach($ReservationDates as $Dates){
            $ArrivalDate = Carbon::parse($Dates->dtmResDArrival);
            $DepartureDate = Carbon::parse($Dates->dtmResDDeparture);
        }
        
        $daysOfStay = $DepartureDate->diffInDays($ArrivalDate);
        
        if($daysOfStay == 0){
            $daysOfStay = 1; 
        } 
        
        $DateTimeToday = Carbon::now('Asia/Manila')->format('Y/m/d h:i:s');
        $DateToday = Carbon::now('Asia/Manila')->format('Y/m/d');
        
        $PaymentID = DB::table('tblPayment')->pluck('strPaymentID')->first();
        if(!$PaymentID){
            $PaymentID = "PYMT1";
        }
        else{
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
        }
      
        //if($OriginalPaymentStatus == 1){

            $PaymentRemarks = collect(['DateUpgraded' => $DateTimeToday, 'ArrivalDate' => $ArrivalDate, 'DepartureDate' => $DepartureDate, 'OriginalRoom' => $RoomName, 'UpgradeRoom' => $NewRoomName, 'NewRoomID' => $NewRoomID]);

            $jsonRemarks = $PaymentRemarks->toJson();

            $TransactionData = array('strPaymentID'=>$PaymentID,
                                      'strPayReservationID'=>$ReservationID,
                                      'dblPayAmount'=>$AmountPaid,
                                      'strPayTypeID'=> 23,
                                      'dtePayDate'=>$DateToday,
                                      'strPaymentRemarks'=>$jsonRemarks);

            DB::table('tblPayment')->insert($TransactionData);
       // }
        
       /* if($OriginalPaymentStatus == 0 || $OriginalPaymentStatus == 2){

            $PaymentRemarks = collect(['DateUpgraded' => $DateTimeToday, 'ArrivalDate' => $ArrivalDate, 'DepartureDate' => $DepartureDate, 'OriginalRoom' => $RoomName, 'UpgradeRoom' => $NewRoomName, 'NewRoomID' => $NewRoomID]);

            $jsonRemarks = $PaymentRemarks->toJson();

            $TransactionData = array('strPaymentID'=>$PaymentID,
                                      'strPayReservationID'=>$ReservationID,
                                      'dblPayAmount'=>$AmountPaid,
                                      'strPayTypeID'=> 22,
                                      'dtePayDate'=>$DateToday,
                                      'strPaymentRemarks'=>$jsonRemarks);
            
            DB::table('tblPayment')->insert($TransactionData);
        }*/
        
        
        \Session::flash('flash_message','Successfully upgraded the room!');
        
        return redirect('/Rooms');
    }
    
    public function fnSaveUpgradeRoom($ReservationID, $RoomName, $NewRoomName, $AmountPaid, $PaymentStatus){
      
        $RoomID = DB::table('tblRoom')->where([['strRoomName', '=', $RoomName],['strRoomStatus','=','Available']])->pluck("strRoomID")->first();
        
        $NewRoomID = DB::table('tblRoom')->where([['strRoomName', '=', $NewRoomName],['strRoomStatus','=','Available']])->pluck("strRoomID")->first();
        
        $RoomPaymentStatus = DB::table('tblReservationRoom')->where([['strResRReservationID', $ReservationID],['strResRRoomID','=', $RoomID]])->pluck("intResRPayment")->first();

        // 1 3 5 7 paid 
        // 0 2 4 6 not paid
        
        // 3 paid add rooms
        
        // 2 not paid add rooms
        
        // 7 paid add rooms and paid upgrade room ---- paid add rooms and paid upgrade room
        
        // 6 not paid add rooms and not paid upgrade room ------ not paid add rooms and not paid upgrade room
        
        // if initial bill is paid and paid now
        

        if(($RoomPaymentStatus % 2) == 0 && $PaymentStatus == 0){
            $PaymentStatus = 6;
            $updateData = array('strResRRoomID' => $NewRoomID,
                            'intResRPayment' => $PaymentStatus);
        }
        
        //if initial bill is not paid and paid now
        else if(($RoomPaymentStatus % 2) == 0 && $PaymentStatus == 1){
            $PaymentStatus = 7;
            $updateData = array('strResRRoomID' => $NewRoomID,
                            'intResRPayment' => $PaymentStatus);
        }
        
        else if(($RoomPaymentStatus % 2) != 0 && $PaymentStatus == 1){
            $PaymentStatus = 7;
            $updateData = array('strResRRoomID' => $NewRoomID,
                            'intResRPayment' => $PaymentStatus);
        }
        
        else if(($RoomPaymentStatus % 2) != 0 && $PaymentStatus == 0){
            $PaymentStatus = 6;
            $updateData = array('strResRRoomID' => $NewRoomID,
                            'intResRPayment' => $PaymentStatus);
        }
  
        DB::table('tblReservationRoom')
            ->where([['strResRReservationID', $ReservationID],['strResRRoomID','=', $RoomID]])
            ->update($updateData);
        
        return $RoomPaymentStatus;
    }

    /*---------------- BILLING -----------------*/

    public function addBillDeduction(Request $req){
        $ReservationID = trim($req->input('ReservationID'));
        $Amount = trim($req->input('DeductAmount'));
        $Remarks = trim($req->input('Remarks'));

        $DateToday = Carbon::now('Asia/Manila')->format('Y/m/d');
        
        $PaymentID = DB::table('tblPayment')->pluck('strPaymentID')->first();
        if(!$PaymentID){
            $PaymentID = "PYMT1";
        }
        else{
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
        }

        $TransactionData = array('strPaymentID'=>$PaymentID,
                                  'strPayReservationID'=>$ReservationID,
                                  'dblPayAmount'=>$Amount,
                                  'strPayTypeID'=> 29,
                                  'dtePayDate'=>$DateToday,
                                  'strPaymentRemarks'=>$Remarks);
    
        DB::table('tblPayment')->insert($TransactionData);

        \Session::flash('flash_message','Successfully done!');
        
        return redirect('/Billing');
    }

    public function editBillDeduction(Request $req){
        $ReservationID = trim($req->input('EditReservationID'));
        $PaymentID = trim($req->input('EditPaymentID'));
        $Amount = trim($req->input('EditDeductAmount'));
        $Remarks = trim($req->input('EditRemarks'));

        $updateData = array('dblPayAmount'=>$Amount,
                            'strPaymentRemarks'=>$Remarks);

        DB::table('tblPayment')
        ->where([['strPayReservationID', $ReservationID],['strPaymentID','=', $PaymentID]])
        ->update($updateData);

        \Session::flash('flash_message','Successfully done!');
        
        return redirect('/Billing');
    }

    public function deleteBillDeduction(Request $req){
        $ReservationID = trim($req->input('DeleteReservationID'));
        $PaymentID = trim($req->input('DeletePaymentID'));

        DB::table('tblPayment')
        ->where([['strPayReservationID', $ReservationID],['strPaymentID','=', $PaymentID]])
        ->delete();

        \Session::flash('flash_message','Successfully done!');
        
        return redirect('/Billing');
    }


    /*-----------------CHECKOUT------------------*/

    public function CheckoutCustomer(Request $req){
        $ReservationID = trim($req->input('s-ReservationID'));
        $TotalAmount = trim($req->input("PayTotal"));
        $PaymentStatus = 1;
        $DateToday = Carbon::now()->toDateString();

        $PaymentID = DB::table('tblPayment')->pluck('strPaymentID')->first();
        if(!$PaymentID){
            $PaymentID = "PYMT1";
        }
        else{
            $PaymentID = $this->SmartCounter('tblPayment', 'strPaymentID');
        }

        $TransactionData = array('strPaymentID'=>$PaymentID,
                                      'strPayReservationID'=>$ReservationID,
                                      'dblPayAmount'=>$TotalAmount,
                                      'strPayTypeID'=> 28,
                                      'dtePayDate'=>$DateToday,
                                      'strPaymentRemarks'=>null);

        DB::table('tblPayment')->insert($TransactionData);

        $updateData = array("intResDStatus" => "5");   
        
        DB::table('tblReservationDetail')
            ->where('strReservationID', '=', $ReservationID)
            ->update($updateData);

        \Session::flash('flash_message','Checkout Successful!');
        
        return redirect('/Customers');
    }
    
    
}

   
