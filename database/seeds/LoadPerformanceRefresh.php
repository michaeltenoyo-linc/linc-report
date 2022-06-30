<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

use App\Models\LoadPerformance;
use App\Models\Company;
use App\Models\dloa_transport;
use App\Models\Loa_transport;
use App\Models\ShipmentBlujay;
use Illuminate\Database\Seeder;
use AzisHapidin\IndoRegion\RawDataGetter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;

class LoadPerformanceRefresh extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @deprecated
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
        //LoadPerformance::truncate();

        //FUSO dan WB
        $csvFile = fopen(base_path("reference/local_blujay/LoadPerformanceBlujay.csv"),"r");
        
        $firstline = true;
        
        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ',','"')) != FALSE){
            if (!$firstline){
                $customer = ShipmentBlujay::where('load_id',$data['0'])->first();
                
                try {
                    LoadPerformance::create([
                        'tms_id' => $data['0'],
                        'created_date' => Carbon::createFromFormat('d/m/Y H:i', $data['1']),
                        'carrier_reference' => $data['2'],
                        'carrier_name' => $data['3'],
                        'equipment_description' => $data['4'],
                        'vehicle_number' => $data['5'],
                        'load_status' => $data['8'],
                        'first_pick_location_name' => $data['9'],
                        'last_drop_location_name' => $data['10'],
                        'routing_guide_name' => $data['15'],
                        'payable_total_rate' => round(floatval(str_replace(',','',$data['18'])),2),
                        'billable_total_rate' => round(floatval(str_replace(',','',$data['19'])),2),
                        'closed_date' =>  ($this->checkDateString($data['20']))?Carbon::createFromFormat('d/m/Y H:i', $data['20']):null,
                        'weight_lb' => round(floatval(str_replace(',','',$data['24'])),2),
                        'weight_kg' => round(floatval(str_replace(',','',$data['25'])),2),
                        'total_distance_km' => round(floatval(str_replace(',','',$data['29'])),2),
                        'routing_guide' => $data['32'],
                        'load_group' => $data['47'],
                        'last_drop_location_reference_number' => $data['52'],
                        'load_contact' => $data['48'],
                        'last_drop_location_city' => $data['53'],
                        'first_pick_location_reference_number' => $data['60'],
                        'first_pick_location_city' => $data['61'],
                        'customer_name' => $customer==null?'':$customer->customer_name,
                        'customer_reference' => $customer==null?'':$customer->customer_reference,
                        'websettle_date' => ($this->checkDateString($data['22']))?Carbon::createFromFormat('d/m/Y H:i', $data['22']):null,
                    ]);

                    
                    error_log("Load Performance : ".$counter." (New)",0);
                } catch (\Throwable $th) {
                    $exist = LoadPerformance::find($data['0']);

                    if(!is_null($exist)){
                        $exist->forceDelete();
                    }

                    LoadPerformance::create([
                        'tms_id' => $data['0'],
                        'created_date' => Carbon::createFromFormat('d/m/Y H:i', $data['1']),
                        'carrier_reference' => $data['2'],
                        'carrier_name' => $data['3'],
                        'equipment_description' => $data['4'],
                        'vehicle_number' => $data['5'],
                        'load_status' => $data['8'],
                        'first_pick_location_name' => $data['9'],
                        'last_drop_location_name' => $data['10'],
                        'routing_guide_name' => $data['15'],
                        'payable_total_rate' => round(floatval(str_replace(',','',$data['18'])),2),
                        'billable_total_rate' => round(floatval(str_replace(',','',$data['19'])),2),
                        'closed_date' =>  ($this->checkDateString($data['20']))?Carbon::createFromFormat('d/m/Y H:i', $data['20']):null,
                        'weight_lb' => round(floatval(str_replace(',','',$data['24'])),2),
                        'weight_kg' => round(floatval(str_replace(',','',$data['25'])),2),
                        'total_distance_km' => round(floatval(str_replace(',','',$data['29'])),2),
                        'routing_guide' => $data['32'],
                        'load_group' => $data['47'],
                        'last_drop_location_reference_number' => $data['52'],
                        'load_contact' => $data['48'],
                        'last_drop_location_city' => $data['53'],
                        'first_pick_location_reference_number' => $data['60'],
                        'first_pick_location_city' => $data['61'],
                        'customer_name' => $customer==null?'':$customer->customer_name,
                        'customer_reference' => $customer==null?'':$customer->customer_reference,
                        'websettle_date' => ($this->checkDateString($data['22']))?Carbon::createFromFormat('d/m/Y H:i', $data['22']):null,
                    ]);

                    error_log("Load Performance : ".$counter." (Exist Updating)",0);
                }
                $counter++;
            }

            $firstline = false;
        }

        fclose($csvFile);
    }
}
