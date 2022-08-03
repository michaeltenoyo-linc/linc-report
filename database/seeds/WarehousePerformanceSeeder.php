<?php

use App\Models\LoadPerformance;
use App\Models\WarehouseCustomer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class WarehousePerformanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function checkDateString($str){
        try {
            Carbon::createFromFormat('d/m/Y H:i', $str);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function run()
    {   
        //SBY KK
        $csvFile = fopen(base_path("reference/local_flux/WarehouseBilling_SBYKK.csv"),"r");
        
        $firstline = true;
        
        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ';','"')) != FALSE){
            if (!$firstline){
                $customer = WarehouseCustomer::find($data['10']);

                try {
                    LoadPerformance::create([
                        'tms_id' => str_replace('*','',$data['0']),
                        'created_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                        'carrier_reference' => $data['9'],
                        'carrier_name' => $data['9'],
                        'equipment_description' => $data['7'],
                        'vehicle_number' => 'Warehouse',
                        'load_status' => 'Closed',
                        'first_pick_location_name' => $data['9'],
                        'last_drop_location_name' => $data['9'],
                        'routing_guide_name' => $data['19'],
                        'payable_total_rate' => $data['29']==''?0:$data['29'],
                        'billable_total_rate' => $data['26'],
                        'closed_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                        'weight_lb' => $data['21']==''?0:$data['21'],
                        'weight_kg' => $data['24']==''?0:$data['24'],
                        'total_distance_km' => 0,
                        'routing_guide' => $data['16'],
                        'load_group' => 'FLUX WAREHOUSE',
                        'last_drop_location_reference_number' => '',
                        'load_contact' => 'Warehouse Admin',
                        'last_drop_location_city' => '',
                        'first_pick_location_reference_number' => '',
                        'first_pick_location_city' => '',
                        'customer_name' => $customer==null?'':$customer->customer_description,
                        'customer_reference' => $customer==null?'':$customer->customer_sap,
                        'websettle_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                    ]);
                    
                    error_log("WH KK : ".$counter." (New)",0);
                } catch (\Throwable $th) {
                    $exist = LoadPerformance::find(str_replace('*','',$data['0']));
    
                    if(!is_null($exist)){
                        $exist->forceDelete();
                    }

                    LoadPerformance::create([
                        'tms_id' => str_replace('*','',$data['0']),
                        'created_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                        'carrier_reference' => $data['9'],
                        'carrier_name' => $data['9'],
                        'equipment_description' => $data['7'],
                        'vehicle_number' => 'Warehouse',
                        'load_status' => 'Closed',
                        'first_pick_location_name' => $data['9'],
                        'last_drop_location_name' => $data['9'],
                        'routing_guide_name' => $data['19'],
                        'payable_total_rate' => $data['29']==''?0:$data['29'],
                        'billable_total_rate' => $data['26'],
                        'closed_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                        'weight_lb' => $data['21']==''?0:$data['21'],
                        'weight_kg' => $data['24']==''?0:$data['24'],
                        'total_distance_km' => 0,
                        'routing_guide' => $data['16'],
                        'load_group' => 'FLUX WAREHOUSE',
                        'last_drop_location_reference_number' => '',
                        'load_contact' => 'Warehouse Admin',
                        'last_drop_location_city' => '',
                        'first_pick_location_reference_number' => '',
                        'first_pick_location_city' => '',
                        'customer_name' => $customer==null?'':$customer->customer_description,
                        'customer_reference' => $customer==null?'':$customer->customer_sap,
                        'websettle_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                    ]);

                    error_log("WH KK : ".$counter." (Exist Updating)",0);
                }
            }
            $firstline = false;
            $counter++;
        }

        fclose($csvFile);

        //SBY MM
        $csvFile = fopen(base_path("reference/local_flux/WarehouseBilling_SBYMM.csv"),"r");
        
        $firstline = true;
        
        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ';','"')) != FALSE){
            if (!$firstline){
                $customer = WarehouseCustomer::find($data['10']);

                try {
                    LoadPerformance::create([
                        'tms_id' => str_replace('*','',$data['0']),
                        'created_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                        'carrier_reference' => $data['9'],
                        'carrier_name' => $data['9'],
                        'equipment_description' => $data['7'],
                        'vehicle_number' => 'Warehouse',
                        'load_status' => 'Closed',
                        'first_pick_location_name' => $data['9'],
                        'last_drop_location_name' => $data['9'],
                        'routing_guide_name' => $data['19'],
                        'payable_total_rate' => $data['29']==''?0:$data['29'],
                        'billable_total_rate' => $data['26'],
                        'closed_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                        'weight_lb' => $data['21']==''?0:$data['21'],
                        'weight_kg' => $data['24']==''?0:$data['24'],
                        'total_distance_km' => 0,
                        'routing_guide' => $data['16'],
                        'load_group' => 'FLUX WAREHOUSE',
                        'last_drop_location_reference_number' => '',
                        'load_contact' => 'Warehouse Admin',
                        'last_drop_location_city' => '',
                        'first_pick_location_reference_number' => '',
                        'first_pick_location_city' => '',
                        'customer_name' => $customer==null?'':$customer->customer_description,
                        'customer_reference' => $customer==null?'':$customer->customer_sap,
                        'websettle_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                    ]);
                    
                    error_log("WH KK : ".$counter." (New)",0);
                } catch (\Throwable $th) {
                    $exist = LoadPerformance::find(str_replace('*','',$data['0']));
    
                    if(!is_null($exist)){
                        $exist->forceDelete();
                    }

                    LoadPerformance::create([
                        'tms_id' => str_replace('*','',$data['0']),
                        'created_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                        'carrier_reference' => $data['9'],
                        'carrier_name' => $data['9'],
                        'equipment_description' => $data['7'],
                        'vehicle_number' => 'Warehouse',
                        'load_status' => 'Closed',
                        'first_pick_location_name' => $data['9'],
                        'last_drop_location_name' => $data['9'],
                        'routing_guide_name' => $data['19'],
                        'payable_total_rate' => $data['29']==''?0:$data['29'],
                        'billable_total_rate' => $data['26'],
                        'closed_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                        'weight_lb' => $data['21']==''?0:$data['21'],
                        'weight_kg' => $data['24']==''?0:$data['24'],
                        'total_distance_km' => 0,
                        'routing_guide' => $data['16'],
                        'load_group' => 'FLUX WAREHOUSE',
                        'last_drop_location_reference_number' => '',
                        'load_contact' => 'Warehouse Admin',
                        'last_drop_location_city' => '',
                        'first_pick_location_reference_number' => '',
                        'first_pick_location_city' => '',
                        'customer_name' => $customer==null?'':$customer->customer_description,
                        'customer_reference' => $customer==null?'':$customer->customer_sap,
                        'websettle_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                    ]);

                    error_log("WH KK : ".$counter." (Exist Updating)",0);
                }
            }
            $firstline = false;
            $counter++;
        }

        fclose($csvFile);

        //SBY SMART01
        $csvFile = fopen(base_path("reference/local_flux/WarehouseBilling_SMARTSBY01.csv"),"r");
        
        $firstline = true;
        
        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ';','"')) != FALSE){
            if (!$firstline){
                $customer = WarehouseCustomer::find($data['10']);

                try {
                    LoadPerformance::create([
                        'tms_id' => str_replace('*','',$data['0']),
                        'created_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                        'carrier_reference' => $data['9'],
                        'carrier_name' => $data['9'],
                        'equipment_description' => $data['7'],
                        'vehicle_number' => 'Warehouse',
                        'load_status' => 'Closed',
                        'first_pick_location_name' => $data['9'],
                        'last_drop_location_name' => $data['9'],
                        'routing_guide_name' => $data['19'],
                        'payable_total_rate' => $data['29']==''?0:$data['29'],
                        'billable_total_rate' => $data['26'],
                        'closed_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                        'weight_lb' => $data['21']==''?0:$data['21'],
                        'weight_kg' => $data['24']==''?0:$data['24'],
                        'total_distance_km' => 0,
                        'routing_guide' => $data['16'],
                        'load_group' => 'FLUX WAREHOUSE',
                        'last_drop_location_reference_number' => '',
                        'load_contact' => 'Warehouse Admin',
                        'last_drop_location_city' => '',
                        'first_pick_location_reference_number' => '',
                        'first_pick_location_city' => '',
                        'customer_name' => $customer==null?'':$customer->customer_description,
                        'customer_reference' => $customer==null?'':$customer->customer_sap,
                        'websettle_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                    ]);
                    
                    error_log("WH KK : ".$counter." (New)",0);
                } catch (\Throwable $th) {
                    $exist = LoadPerformance::find(str_replace('*','',$data['0']));
    
                    if(!is_null($exist)){
                        $exist->forceDelete();
                    }

                    LoadPerformance::create([
                        'tms_id' => str_replace('*','',$data['0']),
                        'created_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                        'carrier_reference' => $data['9'],
                        'carrier_name' => $data['9'],
                        'equipment_description' => $data['7'],
                        'vehicle_number' => 'Warehouse',
                        'load_status' => 'Closed',
                        'first_pick_location_name' => $data['9'],
                        'last_drop_location_name' => $data['9'],
                        'routing_guide_name' => $data['19'],
                        'payable_total_rate' => $data['29']==''?0:$data['29'],
                        'billable_total_rate' => $data['26'],
                        'closed_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                        'weight_lb' => $data['21']==''?0:$data['21'],
                        'weight_kg' => $data['24']==''?0:$data['24'],
                        'total_distance_km' => 0,
                        'routing_guide' => $data['16'],
                        'load_group' => 'FLUX WAREHOUSE',
                        'last_drop_location_reference_number' => '',
                        'load_contact' => 'Warehouse Admin',
                        'last_drop_location_city' => '',
                        'first_pick_location_reference_number' => '',
                        'first_pick_location_city' => '',
                        'customer_name' => $customer==null?'':$customer->customer_description,
                        'customer_reference' => $customer==null?'':$customer->customer_sap,
                        'websettle_date' => Carbon::createFromFormat('Y-m-d', $data['5']),
                    ]);

                    error_log("WH KK : ".$counter." (Exist Updating)",0);
                }
            }
            $firstline = false;
            $counter++;
        }

        fclose($csvFile);
    }
}
