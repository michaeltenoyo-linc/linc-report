<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

use App\Models\Customer;
use App\Models\ShipmentBlujay;
use App\Models\dloa_transport;
use App\Models\Loa_transport;
use Illuminate\Database\Seeder;
use AzisHapidin\IndoRegion\RawDataGetter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ShipmentBlujaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @deprecated
     *
     * @return void
     */
    public function run()
    {
        ShipmentBlujay::truncate();

        //FUSO dan WB
        $csvFile = fopen(base_path("reference/local_blujay/RefreshShipmentBlujay.csv"),"r");
        
        $firstline = true;
        
        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ',','"')) != FALSE){
            error_log($counter,0);
            $counter++;
            if (!$firstline){
                $exist = ShipmentBlujay::find($data['5']);

                if(!is_null($exist)){
                    $exist->forceDelete();
                }

                ShipmentBlujay::create([
                    'order_number'=> $data['5'],
                    'customer_reference'=>$data['0'],
                    'customer_name'=>$data['1'],
                    'load_id'=>$data['2'],
                    'load_group'=>$data['3'],
                    'billable_total_rate'=>round(floatval(str_replace(',','',$data['6'])),2),         
                ]);
            }

            $firstline = false;
        }

        fclose($csvFile);
    }
}
