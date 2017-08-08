<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Artisan;

class ViewDashboardController extends Controller
{
    //
    
    public function getDashboard(){
        
        $PaymentTypes = DB::table('tblPaymentType')->get();
        if(sizeof($PaymentTypes) == 0){
            Artisan::call('db:seed');
        }
        
        return view("Dashboard");
    }
}
