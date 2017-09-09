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
}
