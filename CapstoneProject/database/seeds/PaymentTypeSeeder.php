<?php

use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tblpaymenttype')->insert(array(
             array('strPaymentTypeID'=>'1','strPaymentType'=>'Initial Bill'),
             array('strPaymentTypeID'=>'2','strPaymentType'=>'Down Payment'),
             array('strPaymentTypeID'=>'3','strPaymentType'=>'Initial Payment'),
             array('strPaymentTypeID'=>'4','strPaymentType'=>'Additional Bill'),
             array('strPaymentTypeID'=>'5','strPaymentType'=>'Additional Payment'),
        ));
    }
}
