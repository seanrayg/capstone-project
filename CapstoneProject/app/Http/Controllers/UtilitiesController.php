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
    
    
    /*------------ CONTENT MANAGEMENT ---------*/
    
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
            
            DB::table('tblWebContent')
            ->where('strPageTitle', '=', 'Home Page')
            ->update($updateData);
        }
        
        if($BodyImage1 != null){
            $HomeBodyImages = DB::table('tblWebContent')->where('strPageTitle', 'Home Page')->pluck('strBodyImage')->first();
       
            $tempHomePagePictures = json_decode($HomeBodyImages, true);
            
            $arrHomePictures = [];
            
            foreach($tempHomePagePictures as $Picture){
                $arrHomePictures[sizeof($arrHomePictures)] = $Picture;
            }
        
            //File::delete(public_path().'/'.$arrHomePicture[0]);

            $IlSognoPath = public_path();

            $IlSognoPath = str_replace('CapstoneProject', 'IlSognoWebsite', $IlSognoPath);

            //delete image from ilsognowebsite folder
            //File::delete($IlSognoPath.'/'.$arrHomePicture[0]);
            
            $IlSognoPath = public_path("img");
            $IlSognoPath = str_replace('CapstoneProject', 'IlSognoWebsite', $IlSognoPath);
            $IlSognoPath = $IlSognoPath . "/";

            //save image to capstoneproject
            $req->file('HomeBodyImage1')->move("img", $BodyImage1->getClientOriginalName());

            //save image to ilsognowebsite
            copy(public_path("img/").$BodyImage1->getClientOriginalName(), $IlSognoPath.$BodyImage1->getClientOriginalName()); 

            $BodyImagePath = "/img/" . $BodyImage1->getClientOriginalName();
            
            $arrHomePictures[0] = $BodyImagePath;
         
            $arrHomePageImage = collect($arrHomePictures);
            
            $jsonHomePageImage = $arrHomePageImage->toJson();
 
            $updateData = array('strBodyImage' => $jsonHomePageImage);
            
            DB::table('tblWebContent')
            ->where('strPageTitle', '=', 'Home Page')
            ->update($updateData);
            
        }
        
        if($BodyImage2 != null){
            $HomeBodyImages = DB::table('tblWebContent')->where('strPageTitle', 'Home Page')->pluck('strBodyImage')->first();
       
            $tempHomePagePictures = json_decode($HomeBodyImages, true);
            
            $arrHomePictures = [];
            
            foreach($tempHomePagePictures as $Picture){
                $arrHomePictures[sizeof($arrHomePictures)] = $Picture;
            }
        
            //File::delete(public_path().'/'.$arrHomePicture[1]);

            $IlSognoPath = public_path();

            $IlSognoPath = str_replace('CapstoneProject', 'IlSognoWebsite', $IlSognoPath);

            //delete image from ilsognowebsite folder
            //File::delete($IlSognoPath.'/'.$arrHomePicture[1]);
            
            $IlSognoPath = public_path("img");
            $IlSognoPath = str_replace('CapstoneProject', 'IlSognoWebsite', $IlSognoPath);
            $IlSognoPath = $IlSognoPath . "/";

            //save image to capstoneproject
            $req->file('HomeBodyImage2')->move("img", $BodyImage2->getClientOriginalName());

            //save image to ilsognowebsite
            copy(public_path("img/").$BodyImage2->getClientOriginalName(), $IlSognoPath.$BodyImage2->getClientOriginalName()); 

            $BodyImagePath = "/img/" . $BodyImage2->getClientOriginalName();
            
            $arrHomePictures[1] = $BodyImagePath;
         
            $arrHomePageImage = collect($arrHomePictures);
            
            $jsonHomePageImage = $arrHomePageImage->toJson();
 
            $updateData = array('strBodyImage' => $jsonHomePageImage);
            
            DB::table('tblWebContent')
            ->where('strPageTitle', '=', 'Home Page')
            ->update($updateData);
            
        }
        
        if($BodyImage3 != null){
            $HomeBodyImages = DB::table('tblWebContent')->where('strPageTitle', 'Home Page')->pluck('strBodyImage')->first();
       
            $tempHomePagePictures = json_decode($HomeBodyImages, true);
            
            $arrHomePictures = [];
            
            foreach($tempHomePagePictures as $Picture){
                $arrHomePictures[sizeof($arrHomePictures)] = $Picture;
            }
        
            //File::delete(public_path().'/'.$arrHomePicture[2]);

            $IlSognoPath = public_path();

            $IlSognoPath = str_replace('CapstoneProject', 'IlSognoWebsite', $IlSognoPath);

            //delete image from ilsognowebsite folder
            //File::delete($IlSognoPath.'/'.$arrHomePicture[2]);
            
            $IlSognoPath = public_path("img");
            $IlSognoPath = str_replace('CapstoneProject', 'IlSognoWebsite', $IlSognoPath);
            $IlSognoPath = $IlSognoPath . "/";

            //save image to capstoneproject
            $req->file('HomeBodyImage3')->move("img", $BodyImage3->getClientOriginalName());

            //save image to ilsognowebsite
            copy(public_path("img/").$BodyImage3->getClientOriginalName(), $IlSognoPath.$BodyImage3->getClientOriginalName()); 

            $BodyImagePath = "/img/" . $BodyImage3->getClientOriginalName();
            
            $arrHomePictures[2] = $BodyImagePath;
         
            $arrHomePageImage = collect($arrHomePictures);
            
            $jsonHomePageImage = $arrHomePageImage->toJson();
 
            $updateData = array('strBodyImage' => $jsonHomePageImage);
            
            DB::table('tblWebContent')
            ->where('strPageTitle', '=', 'Home Page')
            ->update($updateData);
            
        }
        
        $updateData = array('strHeaderDescription' => $HeaderDescription,
                            'strBodyDescription' => $BodyDescription);

        DB::table('tblWebContent')
        ->where('strPageTitle', '=', 'Home Page')
        ->update($updateData);
        
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
    
    public function saveAboutUs(Request $req){
        $HeaderImage = Input::file('AboutUsHeader');
        $BodyDescription1 = trim($req->input('AboutDescription1'));
        $BodyDescription2 = trim($req->input('AboutDescription2'));
        $BodyDescription3 = trim($req->input('AboutDescription3'));
        
        if($HeaderImage != null){
            $this->removeImage("About Us");
            
            $IlSognoPath = public_path("img");
            $IlSognoPath = str_replace('CapstoneProject', 'IlSognoWebsite', $IlSognoPath);
            $IlSognoPath = $IlSognoPath . "/";

            //save image to capstoneproject
            $req->file('AboutUsHeader')->move("img", $HeaderImage->getClientOriginalName());

            //save image to ilsognowebsite
            copy(public_path("img/").$HeaderImage->getClientOriginalName(), $IlSognoPath.$HeaderImage->getClientOriginalName()); 

            $HeaderImagePath = "/img/" . $HeaderImage->getClientOriginalName();
            
            $updateData = array('strHeaderImage' => $HeaderImagePath);
            $this->saveWebChanges('About Us', $updateData);
        }
        
        $arrAboutDescription = collect(['AboutDescription1' => $BodyDescription1, 'AboutDescription2' => $BodyDescription2, 'AboutDescription3' => $BodyDescription3]);
            
        $jsonAboutDescription = $arrAboutDescription->toJson();
        
        $updateData = array('strBodyDescription' => $jsonAboutDescription);
        
        $this->saveWebChanges('About Us', $updateData);
        
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
    
    
    /*------------ SYSTEM USERS -------------*/
    
    public function ChangeValue($valueToChange){
        if($valueToChange == "on"){
            $valueToChange = 1;
        }
        else{
            $valueToChange = 0;
        }
        
        return $valueToChange;
    }
    
    public function addUser(Request $req){
    
        $UserID = trim($req->input('UserID'));
        $Username = trim($req->input('Username'));
        $Password = trim($req->input('UserPassword'));
        
        $ToggleRoom = $req->input('ToggleRoom');
        $ToggleBoat = $req->input('ToggleBoat');
        $ToggleFee = $req->input('ToggleFee');
        $ToggleItem = $req->input('ToggleItem');
        $ToggleActivity = $req->input('ToggleActivity');
        $ToggleBilling = $req->input('ToggleBilling');
        $ToggleMaintenance = $req->input('ToggleMaintenance');
        $ToggleUtilities = $req->input('ToggleUtilities');
        $ToggleReports = $req->input('ToggleReports');
        
        $UsernameError = DB::table('tblUser')->where([['intUserStatus',"!=", '0'],['strUsername', $Username]])->first();
                
        if($UsernameError){
            \Session::flash('duplicate_message','User already exists. Please enter a new one to continue.');
            return redirect('/SystemUsers')->withInput();
        }
        else{
            $ToggleRoom = $this->ChangeValue($ToggleRoom);
            $ToggleBoat = $this->ChangeValue($ToggleBoat);
            $ToggleFee = $this->ChangeValue($ToggleFee);
            $ToggleItem = $this->ChangeValue($ToggleItem);
            $ToggleActivity = $this->ChangeValue($ToggleActivity);
            $ToggleBilling = $this->ChangeValue($ToggleBilling);
            $ToggleMaintenance = $this->ChangeValue($ToggleMaintenance);
            $ToggleUtilities = $this->ChangeValue($ToggleUtilities);
            $ToggleReports = $this->ChangeValue($ToggleReports);
            
            $data = array('strUserID'=>$UserID,
                         'strUsername'=>$Username,
                         'strUserPassword'=>$Password,
                         'intUserStatus'=>1,
                         'intRoom' => $ToggleRoom,
                         'intBoat' => $ToggleBoat,
                         'intItem' => $ToggleItem,
                         'intActivity' => $ToggleActivity,
                         'intFee' => $ToggleFee,
                         'intMaintenance' => $ToggleMaintenance,
                         'intBilling' => $ToggleBilling,
                         'intUtilities' => $ToggleUtilities,
                         'intReports' => $ToggleReports);

            DB::table('tblUser')->insert($data);
            
            \Session::flash('flash_message','Successfully added a user!');
        
            return redirect('SystemUsers');
        }
        
    }
    
    public function EditUser(Request $req){
   
        $UserID = trim($req->input('EditUserID'));
        $Username = trim($req->input('EditUsername'));
        $Password = trim($req->input('EditUserPassword'));
        $OldPassword = trim($req->input('EditOldPassword'));
        $OldUsername = trim($req->input('EditOldUsername'));
        
        $ToggleRoom = $req->input('EditToggleRoom');
        $ToggleBoat = $req->input('EditToggleBoat');
        $ToggleFee = $req->input('EditToggleFee');
        $ToggleItem = $req->input('EditToggleItem');
        $ToggleActivity = $req->input('EditToggleActivity');
        $ToggleBilling = $req->input('EditToggleBilling');
        $ToggleMaintenance = $req->input('EditToggleMaintenance');
        $ToggleUtilities = $req->input('EditToggleUtilities');
        $ToggleReports = $req->input('EditToggleReports');
        
        $duplicateError = false;
        if($OldUsername != $Username){
            $UsernameError = DB::table('tblUser')->where([['intUserStatus',"!=", '0'],['strUsername', $Username]])->first();
            if($UsernameError){
                $duplicateError = true; 
                \Session::flash('duplicate_message','User already exists. Please enter a new one to continue.');
                return redirect('/SystemUsers')->withInput();
            }
        }
        
        if(!($duplicateError)){

            $ToggleRoom = $this->ChangeValue($ToggleRoom);
            $ToggleBoat = $this->ChangeValue($ToggleBoat);
            $ToggleFee = $this->ChangeValue($ToggleFee);
            $ToggleItem = $this->ChangeValue($ToggleItem);
            $ToggleActivity = $this->ChangeValue($ToggleActivity);
            $ToggleBilling = $this->ChangeValue($ToggleBilling);
            $ToggleMaintenance = $this->ChangeValue($ToggleMaintenance);
            $ToggleUtilities = $this->ChangeValue($ToggleUtilities);
            $ToggleReports = $this->ChangeValue($ToggleReports);
            
            $NewPassword;
            if($Password != null){
                $NewPassword = $Password;
            }
            else{
                $NewPassword = $OldPassword;
            }
            
            $updateData = array('strUsername'=>$Username,
                                 'strUserPassword'=>$NewPassword,
                                 'intUserStatus'=>1,
                                 'intRoom' => $ToggleRoom,
                                 'intBoat' => $ToggleBoat,
                                 'intItem' => $ToggleItem,
                                 'intActivity' => $ToggleActivity,
                                 'intFee' => $ToggleFee,
                                 'intMaintenance' => $ToggleMaintenance,
                                 'intBilling' => $ToggleBilling,
                                 'intUtilities' => $ToggleUtilities,
                                 'intReports' => $ToggleReports);
            
            DB::table('tblUser')
                ->where('strUserID', '=', $UserID)
                ->update($updateData);
            
            \Session::flash('flash_message','Successfully updated the user!');
        
            return redirect('SystemUsers');
        }
    }
    
    public function DeleteUser(Request $req){
        $UserID = trim($req->input('DeleteUserID'));
        
        $updateData = array('intUserStatus'=>0);

        DB::table('tblUser')
            ->where('strUserID', '=', $UserID)
            ->update($updateData);
        
        \Session::flash('flash_message','Successfully deleted the user!');
        
        return redirect('SystemUsers');
    }
    
    public function AuthenticateUser(Request $req){
        $Username = trim($req->input('Username'));
        $Password = trim($req->input('Password'));
        
        $UserInfo = DB::table('tblUser')->where([['intUserStatus',"!=", '0'],['strUsername', $Username], ['strUserPassword', $Password]])->pluck('strUsername')->first();
    
        if($UserInfo == null){
            \Session::flash('duplicate_message','User does not exist');
            return redirect('/');
        }
        else{
            return redirect('/Dashboard');
        }
    }
}
