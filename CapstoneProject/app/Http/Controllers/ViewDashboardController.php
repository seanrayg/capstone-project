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
use Illuminate\Support\Facades\Artisan;

class ViewDashboardController extends Controller
{
    //
    
    public function getDashboard(){
        
        $PaymentTypes = DB::table('tblPaymentType')->get();
        if(sizeof($PaymentTypes) == 0){
            Artisan::call('db:seed');
        }
        
        $ArrivingGuests = DB::table('tblReservationDetail as a')
                            ->join ('tblCustomer as b', 'a.strResDCustomerID', '=' , 'b.strCustomerID')
                            ->select('a.strReservationID',
                                     DB::raw('CONCAT(b.strCustFirstName , " " , b.strCustLastName) AS Name'),
                                     'a.dtmResDArrival',
                                     'a.dtmResDDeparture',
                                     'b.strCustContact',
                                     'b.strCustEmail')
                            ->where([['a.intResDStatus', '=', '2'], [DB::raw('Date(a.dtmResDArrival)'), '=', Carbon::now('Asia/Manila')->format('Y-m-d')]])
                            ->get();
        
        foreach($ArrivingGuests as $Guest){
            $Guest->dtmResDArrival = Carbon::parse($Guest->dtmResDArrival)->format('g:i A');
            $Guest->dtmResDDeparture = Carbon::parse($Guest->dtmResDDeparture)->format('M j, Y');
        }
        
        $DepartingGuests = DB::table('tblReservationDetail as a')
                            ->join ('tblCustomer as b', 'a.strResDCustomerID', '=' , 'b.strCustomerID')
                            ->select('a.strReservationID',
                                     DB::raw('CONCAT(b.strCustFirstName , " " , b.strCustLastName) AS Name'),
                                     'a.dtmResDDeparture',
                                     'b.strCustContact',
                                     'b.strCustEmail')
                            ->where([['a.intResDStatus', '=', '4'], [DB::raw('Date(a.dtmResDDeparture)'), '=', Carbon::now('Asia/Manila')->format('Y-m-d')]])
                            ->get();
        
        foreach($DepartingGuests as $Guest){
            $Guest->dtmResDDeparture = Carbon::parse($Guest->dtmResDDeparture)->format('g:i A');
        }
        
        $CustomersOnResort = DB::table('tblReservationDetail as a')
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
                            ->where('a.intResDStatus', '=', '4')
                            ->get();
        
        foreach($CustomersOnResort as $Customers){
            $Customers->dtmResDArrival = Carbon::parse($Customers->dtmResDArrival)->format('M j, Y');
            $Customers->dtmResDDeparture = Carbon::parse($Customers->dtmResDDeparture)->format('M j, Y');
        }
        
        $CustomersBooked = DB::table('tblReservationDetail as a')
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
                            ->where('a.intResDStatus', '=', '1')
                            ->orWhere('a.intResDStatus', '=', '2')
                            ->where(DB::raw('Date(a.dteResDBooking)'), '=', Carbon::now('Asia/Manila')->format('Y-m-d'))
                            ->get();
        
        foreach($CustomersBooked as $Customers){
            $Customers->dtmResDArrival = Carbon::parse($Customers->dtmResDArrival)->format('M j, Y');
            $Customers->dtmResDDeparture = Carbon::parse($Customers->dtmResDDeparture)->format('M j, Y');
        }
        
        $ArrivingLength = sizeof($ArrivingGuests);
        $DepartingLength = sizeof($DepartingGuests);
        $ResortLength = sizeof($CustomersOnResort);
        $BookedLength = sizeof($CustomersBooked);
        
        
        
        return view("Dashboard", compact('ArrivingLength', 'DepartingLength', 'ResortLength', 'BookedLength', 'ArrivingGuests', 'DepartingGuests', 'CustomersOnResort', 'CustomersBooked'));
    }
}
