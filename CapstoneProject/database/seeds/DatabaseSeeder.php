<?php

use Illuminate\Database\Seeder;
use database\seeds\PaymentTypeSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Initializes the database 
        DB::table('tblpaymenttype')->insert(array(
             array('strPaymentTypeID'=>'1','strPaymentType'=>'Initial Bill'),
             array('strPaymentTypeID'=>'2','strPaymentType'=>'Down Payment'),
             array('strPaymentTypeID'=>'3','strPaymentType'=>'Initial Payment'),
             array('strPaymentTypeID'=>'4','strPaymentType'=>'Additional Bill'),
             array('strPaymentTypeID'=>'5','strPaymentType'=>'Additional Payment'),
             array('strPaymentTypeID'=>'6','strPaymentType'=>'Time Penalty Bill'),
             array('strPaymentTypeID'=>'7','strPaymentType'=>'Broken/Lost Penalty Bill')
             array('strPaymentTypeID'=>'8','strPaymentType'=>'Boat Reservation Bill')
             array('strPaymentTypeID'=>'9','strPaymentType'=>'Boat Reservation Payment')
        ));
        
        //for verification
        $this->command->info("Payment Type table seeded :)");
    }
}
