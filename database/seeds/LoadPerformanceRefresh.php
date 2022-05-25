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
            error_log("Load Performance : ".$counter,0);
            $counter++;
            if (!$firstline){
                $exist = LoadPerformance::find($data['0']);

                if(!is_null($exist)){
                    $exist->forceDelete();
                }
                
                $customer = ShipmentBlujay::where('load_id',$data['0'])->first();
                
                LoadPerformance::create([
                    'tms_id' => $data['0'],
                    'created_date' => Carbon::createFromFormat('d/m/Y H:i', $data['1']),
                    'carrier_reference' => $data['2'],
                    'carrier_name' => $data['3'],
                    'equipment_description' => $data['4'],
                    'vehicle_number' => $data['5'],
                    'driver_name' => $data['6'],
                    'shipment_reference' => $data['7'],
                    'load_status' => $data['8'],
                    'first_pick_location_name' => $data['9'],
                    'last_drop_location_name' => $data['10'],
                    'first_pick_original_plan_date_start' => $data['11'],
                    'first_pick_appt_end_date' => $data['12'],
                    'last_drop_original_plan_date_start' => $data['13'],
                    'last_drop_appt_end_date' => $data['14'],
                    'routing_guide_name' => $data['15'],
                    'payable_total_base_rate' => round($data['16'],2),
                    'payable_total_accessorials' => round($data['17'],2),
                    'payable_total_rate' => round(floatval(str_replace(',','',$data['18'])),2),
                    'billable_total_rate' => round(floatval(str_replace(',','',$data['19'])),2),
                    'closed_date' =>  ($this->checkDateString($data['20']))?Carbon::createFromFormat('d/m/Y H:i', $data['20']):null,
                    'websettle_batch_status' => $data['21'],
                    'websettle_batch_transmit_date' => $data['22'],
                    'trailer_number' => $data['23'],
                    'weight_lb' => round(floatval(str_replace(',','',$data['24'])),2),
                    'weight_kg' => round(floatval(str_replace(',','',$data['25'])),2),
                    'void_date' => $data['26'],
                    'transportation_mode' => $data['27'],
                    'tour_id' => $data['28'],
                    'total_distance_km' => round(floatval(str_replace(',','',$data['29'])),2),
                    'shipper_load_number' => $data['30'],
                    'routing_guide_first_carrier_carrier_reference' => $data['31'],
                    'routing_guide' => $data['32'],
                    'routed_date_used' => $data['33'],
                    'required_equipment_short_description' => $data['34'],
                    'required_equipment' => $data['35'],
                    'related_order_identifiers' => $data['36'],
                    'purchase_price' => round(floatval(str_replace(',','',$data['37'])),2),
                    'profit_or_loss_pct' => $data['38'],
                    'priority' => $data['39'],
                    'pieces_sum' => $data['40'],
                    'pieces_max' => $data['41'],
                    'pieces' => $data['42'],
                    'matched_routing_guide' => $data['43'],
                    'load_websettle_hold_status' => $data['44'],
                    'load_reference_numbers' => $data['45'],
                    'load_profit_loss_amount' => $data['46'],
                    'load_group' => $data['47'],
                    'load_contact' => $data['48'],
                    'linear_space_m' => $data['49'],
                    'linear_space_ft' => $data['50'],
                    'last_drop_original_plan_date_end' => $data['51'],
                    'last_drop_location_reference_number' => $data['52'],
                    'last_drop_location_city' => $data['53'],
                    'last_drop_has_pod' => $data['54'],
                    'last_drop_calculated_date' => $data['55'],
                    'last_drop_arrival_date' => $data['56'],
                    'intermediate_stops' => $data['57'],
                    'first_routing_guide_carrier_base_rate' => round(floatval(str_replace(',','',$data['58'])),2),
                    'first_pick_original_plan_date_end' => $data['59'],
                    'first_pick_location_reference_number' => $data['60'],
                    'first_pick_location_city' => $data['61'],
                    'first_pick_has_pod' => $data['62'],
                    'first_pick_eta_date' => $data['63'],
                    'first_pick_departure_date' => $data['64'],
                    'first_pick_calculated_due_date_indicator' => $data['65'],
                    'first_pick_calculated_date' => $data['66'],
                    'first_pick_appt_start_date' => $data['67'],
                    'first_pick_appt_scheduled_date' => $data['68'],
                    'first_pick_appointment_requested_date' => $data['69'],
                    'division' => $data['70'],
                    'data_mart_update_date' => $data['71'],
                    'carrier_rank_when_tendered' => $data['72'],
                    'first_pick_appointment_confirmed_date' => $data['73'],
                    'last_drop_eta_date' => $data['74'],
                    'last_drop_departure_date' => $data['74'],
                    'websettle_batch_name' => $data['75'],
                    'carrier_rate_modified' => $data['76'],
                    'carrier_vendor_number' => $data['77'],
                    'creation_process' => $data['78'],
                    'driver_name2' => $data['79'],
                    'execution_plan_rank' => $data['80'],
                    'customer_name' => $customer==null?'':$customer->customer_name,
                    'customer_reference' => $customer==null?'':$customer->customer_reference,
                ]);
            }

            $firstline = false;
        }

        fclose($csvFile);
    }
}
