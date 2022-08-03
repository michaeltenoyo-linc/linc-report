<?php

use App\Models\WarehouseCustomer;
use Illuminate\Database\Seeder;

class WarehouseCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WarehouseCustomer::truncate();

        $csvFile = fopen(base_path("reference/local_flux/WarehouseCustomerFlux.csv"),"r");
        
        $firstline = true;

        while(($data = fgetcsv($csvFile, 0, ';','"')) != FALSE){
            if (!$firstline){
                WarehouseCustomer::create([
                    'customer_number' => $data['0'],
                    'customer_description' => $data['5'],
                    'customer_sap' => $data['25'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
