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
use File;

class UtilitiesController extends Controller
{
    //
    
    /*------------- CONTACT INFORMATION ----------*/
    public function saveContactInfo(Request $req){
        $ContactID = trim($req->input('ContactID'));
        $ContactName = trim($req->input('ContactName'));
        $ContactDetail = trim($req->input('ContactDetails'));
        
        $ContactNameError = DB::table('tblContact')->where([['intContactStatus',"!=", '0'],['strContactName', $ContactName]])->first();
                
        if($ContactNameError){
            \Session::flash('duplicate_message','Contact already exists. Please enter a new one to continue.');
            return redirect('/ContactInformation')->withInput();
        }
        else{
            $data = array('strContactID'=>$ContactID,
                         'strContactName'=>$ContactName,
                         'strContactDetails'=>$ContactDetail,
                         'intContactStatus'=>1);

            DB::table('tblContact')->insert($data);
            
            \Session::flash('flash_message','Successfully added contact information!');
        
            return redirect('ContactInformation');
        }
    }
    
    public function editContactInfo(Request $req){
        $ContactID = trim($req->input('EditContactID'));
        $ContactName = trim($req->input('EditContactName'));
        $ContactDetail = trim($req->input('EditContactDetails'));
        $ContactStatus = trim($req->input('EditContactStatus'));
        $OldContactName = trim($req->input('OldContactName'));
        $duplicateError = false;
        if($OldContactName != $ContactName){
            $ContactNameError = DB::table('tblContact')->where([['intContactStatus',"!=", '0'],['strContactName', $ContactName]])->first();
            if($ContactNameError){
                $duplicateError = true; 
                \Session::flash('duplicate_message','Contact already exists. Please enter a new one to continue.');
                return redirect('/ContactInformation')->withInput();
            }
        }
        
        if(!($duplicateError)){
            if($ContactStatus == "Inactive"){
                $ContactStatus = 2;
            }
            else{
                $ContactStatus = 1;
            }
            $updateData = array('strContactName'=>$ContactName,
                                'strContactDetails'=>$ContactDetail,
                                'intContactStatus'=>$ContactStatus);

            DB::table('tblContact')
                ->where('strContactID', '=', $ContactID)
                ->update($updateData);
            
            \Session::flash('flash_message','Successfully updated the contact information!');
        
            return redirect('ContactInformation');
        }
    }
    
    public function deleteContactInfo(Request $req){
        $ContactID = trim($req->input('DeleteContactID'));
        
        $updateData = array('intContactStatus'=>0);

        DB::table('tblContact')
            ->where('strContactID', '=', $ContactID)
            ->update($updateData);
        
        \Session::flash('flash_message','Successfully deleted the contact information!');
        
        return redirect('ContactInformation');
    }
    
    public function saveHomePage(Request $req){
        $HeaderImage = Input::file('HomePageHeader');
        $BodyImage1 = Input::file('HomeBodyImage1');
        $BodyImage2 = Input::file('HomeBodyImage2');
        $BodyImage3 = Input::file('HomeBodyImage3');
        $HeaderDescription = trim($req->input('HomePageHeaderDesc'));
        $BodyDescription = trim($req->input('HomePageBodyDesc'));
        
        if($HeaderImage != null){
            $this->removeImage("Home Page");
            
            $IlSognoPath = public_path("img");
            $IlSognoPath = str_replace('CapstoneProject', 'IlSognoWebsite', $IlSognoPath);
            $IlSognoPath = $IlSognoPath . "/";

            //save image to capstoneproject
            $req->file('HomePageHeader')->move("img", $HeaderImage->getClientOriginalName());

            //save image to ilsognowebsite
            copy(public_path("img/").$HeaderImage->getClientOriginalName(), $IlSognoPath.$HeaderImage->getClientOriginalName()); 

            $HeaderImagePath = "/img/" . $HeaderImage->getClientOriginalName();
            
            $updateData = array('strHeaderImage' => $HeaderImagePath);
        }
        
        if($BodyImage1 != null){
            /*$HomePageContents = DB::table('tblWebContent')->where('strPageTitle', 'Home Page')->get();
 
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
            }*/
        }
   
            $updateData = array('strHeaderDescription' => $HeaderDescription,
                                'strBodyDescription' => $BodyDescription);
        
        
        
        
        $this->saveWebChanges('Home Page', $updateData);
        
         \Session::flash('flash_message','Successfully updated the page!');
        return redirect('/ContentManagement');
        
    }
    
    public function saveAccommodation(Request $req){
        $HeaderImage = Input::file('AccommodationHeader');
        $HeaderDescription = trim($req->input('AccommodationDescription'));
        
        if($HeaderImage != null){
            $this->removeImage("Accommodation");
            
            $IlSognoPath = public_path("img");
            $IlSognoPath = str_replace('CapstoneProject', 'IlSognoWebsite', $IlSognoPath);
            $IlSognoPath = $IlSognoPath . "/";

            //save image to capstoneproject
            $req->file('AccommodationHeader')->move("img", $HeaderImage->getClientOriginalName());

            //save image to ilsognowebsite
            copy(public_path("img/").$HeaderImage->getClientOriginalName(), $IlSognoPath.$HeaderImage->getClientOriginalName()); 

            $HeaderImagePath = "/img/" . $HeaderImage->getClientOriginalName();
            
            $updateData = array('strHeaderImage' => $HeaderImagePath, 
                                'strHeaderDescription' => $HeaderDescription);
        }
        else{
            $updateData = array('strHeaderDescription' => $HeaderDescription);
        }
        
        $this->saveWebChanges('Accommodation', $updateData);
        
         \Session::flash('flash_message','Successfully updated the page!');
        return redirect('/ContentManagement');
    }
    
    public function savePackages(Request $req){
        $HeaderImage = Input::file('PackagesHeader');
        $HeaderDescription = trim($req->input('PackagesDescription'));
        
        if($HeaderImage != null){
            $this->removeImage("Packages");
            
            $IlSognoPath = public_path("img");
            $IlSognoPath = str_replace('CapstoneProject', 'IlSognoWebsite', $IlSognoPath);
            $IlSognoPath = $IlSognoPath . "/";

            //save image to capstoneproject
            $req->file('PackagesHeader')->move("img", $HeaderImage->getClientOriginalName());

            //save image to ilsognowebsite
            copy(public_path("img/").$HeaderImage->getClientOriginalName(), $IlSognoPath.$HeaderImage->getClientOriginalName()); 

            $HeaderImagePath = "/img/" . $HeaderImage->getClientOriginalName();
            
            $updateData = array('strHeaderImage' => $HeaderImagePath, 
                                'strHeaderDescription' => $HeaderDescription);
        }
        else{
            $updateData = array('strHeaderDescription' => $HeaderDescription);
        }
        
        $this->saveWebChanges('Packages', $updateData);
        
         \Session::flash('flash_message','Successfully updated the page!');
        return redirect('/ContentManagement');
        
    }
    
    public function saveActivities(Request $req){
        $HeaderImage = Input::file('ActivitiesHeader');
        $HeaderDescription = trim($req->input('ActivitiesDescription'));
        
        if($HeaderImage != null){
            $this->removeImage("Activities");
            
            $IlSognoPath = public_path("img");
            $IlSognoPath = str_replace('CapstoneProject', 'IlSognoWebsite', $IlSognoPath);
            $IlSognoPath = $IlSognoPath . "/";

            //save image to capstoneproject
            $req->file('ActivitiesHeader')->move("img", $HeaderImage->getClientOriginalName());

            //save image to ilsognowebsite
            copy(public_path("img/").$HeaderImage->getClientOriginalName(), $IlSognoPath.$HeaderImage->getClientOriginalName()); 

            $HeaderImagePath = "/img/" . $HeaderImage->getClientOriginalName();
            
            $updateData = array('strHeaderImage' => $HeaderImagePath, 
                                'strHeaderDescription' => $HeaderDescription);
        }
        else{
            $updateData = array('strHeaderDescription' => $HeaderDescription);
        }
        
        $this->saveWebChanges('Activities', $updateData);
        
         \Session::flash('flash_message','Successfully updated the page!');
        return redirect('/ContentManagement');
        
    }
    
    public function saveContacts(Request $req){
        $HeaderImage = Input::file('ContactsHeader');
        $HeaderDescription = trim($req->input('ContactsDescription'));
        
        if($HeaderImage != null){
            $this->removeImage("Contact Us");
            
            $IlSognoPath = public_path("img");
            $IlSognoPath = str_replace('CapstoneProject', 'IlSognoWebsite', $IlSognoPath);
            $IlSognoPath = $IlSognoPath . "/";

            //save image to capstoneproject
            $req->file('ContactsHeader')->move("img", $HeaderImage->getClientOriginalName());

            //save image to ilsognowebsite
            copy(public_path("img/").$HeaderImage->getClientOriginalName(), $IlSognoPath.$HeaderImage->getClientOriginalName()); 

            $HeaderImagePath = "/img/" . $HeaderImage->getClientOriginalName();
            
            $updateData = array('strHeaderImage' => $HeaderImagePath, 
                                'strHeaderDescription' => $HeaderDescription);
        }
        else{
            $updateData = array('strHeaderDescription' => $HeaderDescription);
        }
        
        $this->saveWebChanges('Contact Us', $updateData);
        
         \Session::flash('flash_message','Successfully updated the page!');
        return redirect('/ContentManagement');
        
    }
    
    public function saveLocation(Request $req){
        $HeaderImage = Input::file('LocationHeader');
        $BodyImage = Input::file('LocationBody');
        $BodyDescription = trim($req->input('LocationBodyDescription'));
        $HeaderDescription = trim($req->input('LocationDescription'));
        
        if($HeaderImage != null){
            $this->removeImage("Location");
            
            $IlSognoPath = public_path("img");
            $IlSognoPath = str_replace('CapstoneProject', 'IlSognoWebsite', $IlSognoPath);
            $IlSognoPath = $IlSognoPath . "/";

            //save image to capstoneproject
            $req->file('LocationHeader')->move("img", $HeaderImage->getClientOriginalName());

            //save image to ilsognowebsite
            copy(public_path("img/").$HeaderImage->getClientOriginalName(), $IlSognoPath.$HeaderImage->getClientOriginalName()); 

            $HeaderImagePath = "/img/" . $HeaderImage->getClientOriginalName();
            
            $updateData = array('strHeaderImage' => $HeaderImagePath);
            $this->saveWebChanges('Location', $updateData);
        }
        if($BodyImage != null){
            $OrigHeaderImage = DB::table('tblWebContent')
                            ->where('strPageTitle', '=', 'Location')
                            ->pluck('strBodyImage')
                            ->first();
        
            //File::delete(public_path().'/'.$OrigHeaderImage);

            $IlSognoPath = public_path();

            $IlSognoPath = str_replace('CapstoneProject', 'IlSognoWebsite', $IlSognoPath);

            //delete image from ilsognowebsite folder
            //File::delete($IlSognoPath.'/'.$OrigHeaderImage);
            
            $IlSognoPath = public_path("img");
            $IlSognoPath = str_replace('CapstoneProject', 'IlSognoWebsite', $IlSognoPath);
            $IlSognoPath = $IlSognoPath . "/";

            //save image to capstoneproject
            $req->file('LocationBody')->move("img", $BodyImage->getClientOriginalName());

            //save image to ilsognowebsite
            copy(public_path("img/").$BodyImage->getClientOriginalName(), $IlSognoPath.$BodyImage->getClientOriginalName()); 

            $BodyImagePath = "/img/" . $BodyImage->getClientOriginalName();
            
            $updateData = array('strBodyImage' => $BodyImagePath);
            $this->saveWebChanges('Location', $updateData);
        }

        $updateData = array('strHeaderDescription' => $HeaderDescription,
                            'strBodyDescription' => $BodyDescription);
        $this->saveWebChanges('Location', $updateData);
        
        \Session::flash('flash_message','Successfully updated the page!');
        return redirect('/ContentManagement');
        
    }
    
    public function removeImage($PageTitle){
        
        $OrigHeaderImage = DB::table('tblWebContent')
                            ->where('strPageTitle', '=', $PageTitle)
                            ->pluck('strHeaderImage')
                            ->first();
        
        //File::delete(public_path().'/'.$OrigHeaderImage);

        $IlSognoPath = public_path();

        $IlSognoPath = str_replace('CapstoneProject', 'IlSognoWebsite', $IlSognoPath);

        //delete image from ilsognowebsite folder
        //File::delete($IlSognoPath.'/'.$OrigHeaderImage);
    }
    
    public function saveWebChanges($PageTitle, $updateData){
        DB::table('tblWebContent')
            ->where('strPageTitle', '=', $PageTitle)
            ->update($updateData);
    }
}
