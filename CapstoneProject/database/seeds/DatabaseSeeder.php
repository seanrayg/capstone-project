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
             array('strPaymentTypeID'=>'7','strPaymentType'=>'Broken/Lost Penalty Bill'),
             array('strPaymentTypeID'=>'8','strPaymentType'=>'Boat Reservation Bill'),
             array('strPaymentTypeID'=>'9','strPaymentType'=>'Boat Reservation Payment'),
             array('strPaymentTypeID'=>'10','strPaymentType'=>'Extend Item Bill'),
             array('strPaymentTypeID'=>'11', 'strPaymentType'=>'Item Rental Bill'),
             array('strPaymentTypeID'=>'12', 'strPaymentType'=>'Item Rental Payment'),
             array('strPaymentTypeID'=>'13', 'strPaymentType'=>'Time Penalty Payment'),
             array('strPaymentTypeID'=>'14', 'strPaymentType'=>'Broken/Lost Penalty Payment'),
             array('strPaymentTypeID'=>'15', 'strPaymentType'=>'Extend Item Payment'),
             array('strPaymentTypeID'=>'16', 'strPaymentType'=>'Beach Activity Bill'),
             array('strPaymentTypeID'=>'17', 'strPaymentType'=>'Beach Activity Payment')
        ));
        
        //for verification
        $this->command->info("Payment Type table seeded :)");
    }
}
