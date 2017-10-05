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
        
        $WebContents = DB::table('tblWebContent')->get();
       
        if(sizeof($WebContents) == 0){
            
            $arrHomePageImage = collect(['HomeBodyImage1' => '/img/filler-1.jpg', 'HomeBodyImage2' => '/img/filler-2.jpg', 'HomeBodyImage3' => '/img/filler-3.jpg']);
            
            $arrAboutDescription = collect(['AboutDescription1' => '/img/filler-1.jpg', 'AboutDescription2' => '/img/filler-2.jpg', 'AboutDescription3' => '/img/filler-3.jpg']);
            
            $jsonAboutDescription = $arrAboutDescription->toJson();
            
            $jsonHomePageImage = $arrHomePageImage->toJson();
         
            $arrContentInsert = array(
                array('strPageTitle' => 'Home Page', 'strHeaderDescription' => 'Header Description', 'strHeaderImage' => '/img/header-1.jpeg', 'strBodyImage' => $jsonHomePageImage, 'strBodyDescription' => 'Body Description'),
                array('strPageTitle' => 'Accommodation', 'strHeaderDescription' => 'Header Description', 'strHeaderImage' => '/img/header-2.jpg', 'strBodyImage' => null, 'strBodyDescription' => null),
                array('strPageTitle' => 'Packages', 'strHeaderDescription' => 'Header Description', 'strHeaderImage' => '/img/header-6.jpg', 'strBodyImage' => null, 'strBodyDescription' => null),
                array('strPageTitle' => 'Activities', 'strHeaderDescription' => 'Header Description', 'strHeaderImage' => '/img/header-7.jpg', 'strBodyImage' => null, 'strBodyDescription' => null),
                array('strPageTitle' => 'Location', 'strHeaderDescription' => 'Header Description', 'strHeaderImage' => '/img/header-3.jpg', 'strBodyImage' => null, 'strBodyDescription' => null),
                array('strPageTitle' => 'About Us', 'strHeaderDescription' => 'Header Description', 'strHeaderImage' => '/img/header-4.jpg', 'strBodyImage' => null, 'strBodyDescription' => $jsonAboutDescription),
                array('strPageTitle' => 'Contact Us', 'strHeaderDescription' => 'Header Description', 'strHeaderImage' => '/img/header-5.jpg', 'strBodyImage' => null, 'strBodyDescription' => null)
            );
            
     
            
             DB::table('tblWebContent')->insert($arrContentInsert);
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
        
        $Customers3rdDay = DB::table('tblReservationDetail as a')
                            ->join ('tblCustomer as b', 'a.strResDCustomerID', '=' , 'b.strCustomerID')
                            ->join ('tblPayment as c', 'c.strPayReservationID', '=', 'a.strReservationID')
                            ->select('a.strReservationID',
                                     DB::raw('CONCAT(b.strCustFirstName , " " , b.strCustLastName) AS Name'),
                                     'a.dteResDBooking',
                                     DB::raw('DATE_ADD(a.dteResDBooking, INTERVAL 7 DAY) AS PaymentDueDate'),
                                     'b.strCustContact',
                                     'b.strCustEmail',
                                     'c.dblPayAmount',
                                     DB::raw('b.strCustAddress AS RequiredDownPayment'))
                            ->where('a.intResDStatus', '=', '1')
                            ->where(DB::raw('date(DATE_ADD(a.dteResDBooking, INTERVAL 3 DAY))'), '=', Carbon::now('Asia/Manila')->format('Y-m-d'))
                            ->get();
        
        foreach($Customers3rdDay as $Customer){
            $Customer->RequiredDownPayment = ceil($Customer->dblPayAmount * .20);
            $Customer->PaymentDueDate = Carbon::parse($Customer->PaymentDueDate)->format('M j, Y');
            $Customer->dteResDBooking = Carbon::parse($Customer->dteResDBooking)->format('M j, Y');
        }
        
        $Customers5thDay = DB::table('tblReservationDetail as a')
                            ->join ('tblCustomer as b', 'a.strResDCustomerID', '=' , 'b.strCustomerID')
                            ->join ('tblPayment as c', 'c.strPayReservationID', '=', 'a.strReservationID')
                            ->select('a.strReservationID',
                                     DB::raw('CONCAT(b.strCustFirstName , " " , b.strCustLastName) AS Name'),
                                     'a.dteResDBooking',
                                     DB::raw('DATE_ADD(a.dteResDBooking, INTERVAL 7 DAY) AS PaymentDueDate'),
                                     'b.strCustContact',
                                     'b.strCustEmail',
                                     'c.dblPayAmount',
                                     DB::raw('b.strCustAddress AS RequiredDownPayment'))
                            ->where('a.intResDStatus', '=', '1')
                            ->where(DB::raw('date(DATE_ADD(a.dteResDBooking, INTERVAL 5 DAY))'), '=', Carbon::now('Asia/Manila')->format('Y-m-d'))
                            ->get();
        
        foreach($Customers5thDay as $Customer){
            $Customer->RequiredDownPayment = ceil($Customer->dblPayAmount * .20);
            $Customer->PaymentDueDate = Carbon::parse($Customer->PaymentDueDate)->format('M j, Y');
            $Customer->dteResDBooking = Carbon::parse($Customer->dteResDBooking)->format('M j, Y');
        }
        
        $ContactNumber = DB::table('tblContact')->where('strContactName', '=', 'Telephone')->orWhere('strContactName', '=', 'Hotline')->orWhere('strContactName', '=', 'Phone')->orWhere('strContactName', '=', 'Cellphone')->pluck('strContactDetails')->first();

        $this->getWeeklyIncome();
        return view("Dashboard", compact('ArrivingLength', 'DepartingLength', 'ResortLength', 'BookedLength', 'ArrivingGuests', 'DepartingGuests', 'CustomersOnResort', 'CustomersBooked', 'Customers3rdDay', 'ContactNumber', 'Customers5thDay'));
    }

    public function getIncome($SelectedDate){
        $idArray = [5, 2, 3, 6, 9, 12, 13, 14, 15, 17, 19, 21, 23, 25, 28];
        $IncomeBreakdown = DB::table('tblPayment')
                        ->where(DB::raw('Date(dtePayDate)'), '=', $SelectedDate)
                        ->whereIn('strPayTypeID', $idArray)
                        ->pluck('dblPayAmount');

        $TotalIncome = 0;
        for($x = 0; $x < sizeof($IncomeBreakdown); $x++){
            $TotalIncome += $IncomeBreakdown[$x];
        }

        return $TotalIncome;
    }

    public function getWeeklyIncome(){
        $DateToday = Carbon::now()->startOfWeek()->format('Y-m-d');
        $weekMap = [
            0 => 'SU',
            1 => 'MO',
            2 => 'TU',
            3 => 'WE',
            4 => 'TH',
            5 => 'FR',
            6 => 'SA',
        ];

        for($x = 0; $x < sizeof($weekMap); $x++){
            if($x == 0){
                $weekMap[$x] = $this->getIncome(carbon::parse($DateToday)->format('Y-m-d'));
            }
            else{
                $weekMap[$x] = $this->getIncome(carbon::parse($DateToday)->addDays($x)->format('Y-m-d'));
            }
        }

        return response()->json($weekMap);
    }

    public function getBooking($SelectedDate){
        $CountBooking = DB::table('tblReservationDetail')->where(DB::raw('Date(dteResDBooking)'), '=', $SelectedDate)->count();

        return $CountBooking;
    }

    public function getReservationCount($SelectedMonth){
      
        $SelectedMonth = Carbon::parse($SelectedMonth)->format('m');
        $SelectedYear = Carbon::now()->format('Y');
   
        $CountReservation = DB::table('tblReservationDetail')->whereMonth('dtmResDArrival', '=', $SelectedMonth)->whereYear('dtmResDArrival', '=', $SelectedYear)->count();

        return $CountReservation;
    }

    public function getBookingFrequency(){
        $DateToday = Carbon::now()->startOfWeek()->format('Y-m-d');
        $TodayBooking = $this->getBooking($DateToday);
        $TomorrowBooking = $this->getBooking(carbon::parse($DateToday)->addDays(1)->format('Y-m-d'));
        $ThirdDayBooking = $this->getBooking(carbon::parse($DateToday)->addDays(2)->format('Y-m-d'));
        $FouthDayBooking = $this->getBooking(carbon::parse($DateToday)->addDays(3)->format('Y-m-d'));
        $FifthDayBooking = $this->getBooking(carbon::parse($DateToday)->addDays(4)->format('Y-m-d'));
        $SixthDayBooking = $this->getBooking(carbon::parse($DateToday)->addDays(5)->format('Y-m-d'));
        $SeventhDayBooking = $this->getBooking(carbon::parse($DateToday)->addDays(6)->format('Y-m-d'));

        $weekMap = [
            0 => 'SU',
            1 => 'MO',
            2 => 'TU',
            3 => 'WE',
            4 => 'TH',
            5 => 'FR',
            6 => 'SA',
        ];

        $weekMap[Carbon::parse($DateToday)->dayOfWeek] = $TodayBooking;
        $weekMap[carbon::parse($DateToday)->addDays(1)->dayOfWeek] = $TomorrowBooking;
        $weekMap[carbon::parse($DateToday)->addDays(2)->dayOfWeek] = $ThirdDayBooking;
        $weekMap[carbon::parse($DateToday)->addDays(3)->dayOfWeek] = $FouthDayBooking;
        $weekMap[carbon::parse($DateToday)->addDays(4)->dayOfWeek] = $FifthDayBooking;
        $weekMap[carbon::parse($DateToday)->addDays(5)->dayOfWeek] = $SixthDayBooking;
        $weekMap[carbon::parse($DateToday)->addDays(6)->dayOfWeek] = $SeventhDayBooking;

        return response()->json($weekMap);

    }

    public function getMonthlyReservation(){
        $monthMap = [
            0 => 'January',
            1 => 'February',
            2 => 'March',
            3 => 'April',
            4 => 'May',
            5 => 'June',
            6 => 'July',
            7 => 'August',
            8 => 'September',
            9 => 'October',
            10 => 'November',
            11 => 'December',
        ];

        for($x = 0; $x < sizeof($monthMap); $x++){
            $monthMap[$x] = $this->getReservationCount($monthMap[$x]);
        }

        return response()->json($monthMap);
    }
}
