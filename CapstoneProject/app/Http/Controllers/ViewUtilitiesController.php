<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


class ViewUtilitiesController extends Controller
{
    //
    
    public function ViewContact(){
        
        $Contacts = DB::table('tblContact')
                ->where('intContactStatus', '!=', '0')
                ->get();
        
        if(sizeof($Contacts) != 0){
            $ContactID = $this->SmartCounter('tblContact', 'strContactID');
        }
        else{
            $ContactID = "CNCT1";
        }
        
        foreach($Contacts as $Contact){
            if($Contact->intContactStatus == 1){
                $Contact->intContactStatus = "Active";
            }
            else{
                $Contact->intContactStatus = "Inactive";
            }
        }
        
        return View('ContactInformation', compact('Contacts', 'ContactID'));
    }
    
    public function ViewContentManagement(){
        
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
       
        //ACCOMMODATION
        $AccommodationContents = DB::table('tblWebContent')->where('strPageTitle', 'Accommodation')->get();
        
        //PACKAGES
        $PackagesContents = DB::table('tblWebContent')->where('strPageTitle', 'Packages')->get();
        
        //ACTIVITIES
        $ActivitiesContents = DB::table('tblWebContent')->where('strPageTitle', 'Activities')->get();
        
        //CONTACT US
        $ContactsContents = DB::table('tblWebContent')->where('strPageTitle', 'Contact Us')->get();
        
        //CONTACT US
        $LocationContents = DB::table('tblWebContent')->where('strPageTitle', 'Location')->get();
        
        //ABOUT US
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

        return View('ContentManagement', compact('HomePageContents', 'HomePagePictures', 'AccommodationContents', 'PackagesContents', 'ActivitiesContents', 'ContactsContents', 'LocationContents', 'AboutContents', 'AboutDescriptions'));
    }
    
    public function ViewSystemUsers(){
        $SystemUsers = DB::table('tblUser')->get();
        
        if(sizeof($SystemUsers) != 0){
            $UserID = $this->SmartCounter('tblUser', 'strUserID');
        }
        else{
            $UserID = "USER1";
        }
        
        $SystemUsers = DB::table('tblUser')
                ->where('intUserStatus', '!=', '0')
                ->get();
        
        foreach($SystemUsers as $User){
            if($User->intRoom == "1"){
                $User->intRoom = "Yes";
            }
            else{
                $User->intRoom = "No";
            }
            
            if($User->intBoat == "1"){
                $User->intBoat = "Yes";
            }
            else{
                $User->intBoat = "No";
            }
            
            if($User->intItem == "1"){
                $User->intItem = "Yes";
            }
            else{
                $User->intItem = "No";
            }
            
            if($User->intActivity == "1"){
                $User->intActivity = "Yes";
            }
            else{
                $User->intActivity = "No";
            }
            
            if($User->intFee == "1"){
                $User->intFee = "Yes";
            }
            else{
                $User->intFee = "No";
            }
            
            if($User->intMaintenance == "1"){
                $User->intMaintenance = "Yes";
            }
            else{
                $User->intMaintenance = "No";
            }
            
            if($User->intBilling == "1"){
                $User->intBilling = "Yes";
            }
            else{
                $User->intBilling = "No";
            }
            
            if($User->intUtilities == "1"){
                $User->intUtilities = "Yes";
            }
            else{
                $User->intUtilities = "No";
            }
            
            if($User->intReports == "1"){
                $User->intReports = "Yes";
            }
            else{
                $User->intReports = "No";
            }
        }
        return View('SystemUsers', compact('UserID', 'SystemUsers'));
    }
    
    public function getUserRestrictions(Request $req){
        $Username = trim($req->input('Username'));
        
        $UserRestrictions = DB::table('tblUser')
                ->where([['intUserStatus', '!=', '0'],['strUsername', '=', $Username]])
                ->get();
        
        return response()->json($UserRestrictions);
    }
    
    /*----------- MISC ----------------*/
    
    //SmartCounter
    
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
