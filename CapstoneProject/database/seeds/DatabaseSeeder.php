<?php

use Illuminate\Database\Seeder;

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
        $this->call(PaymentTypeSeeder::class);
        
        //for verification
        $this->command->info("Payment Type table seeded :)");
    }
}
