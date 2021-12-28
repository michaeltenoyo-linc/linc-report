<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadPerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('load_performances', function (Blueprint $table) {
            $table->string('tms_id')->primary();
            $table->datetime('created_date');
            $table->longText('carrier_reference');
            $table->longText('carrier_name');
            $table->longText('equipment_description');
            $table->longText('vehicle_number');
            $table->longText('driver_name');
            $table->longText('shipment_reference');
            $table->longText('load_status');
            $table->longText('first_pick_location_name');
            $table->longText('last_drop_location_name');
            $table->longText('first_pick_original_plan_date_start');
            $table->longText('first_pick_appt_end_date');
            $table->longText('last_drop_original_plan_date_start');
            $table->longText('last_drop_appt_end_date');
            $table->longText('routing_guide_name');
            $table->longText('payable_total_base_rate');
            $table->longText('payable_total_accessorials');
            $table->longText('payable_total_rate');
            $table->longText('billable_total_rate');
            $table->datetime('closed_date')->nullable();
            $table->longText('websettle_batch_status');
            $table->longText('websettle_batch_transmit_date');
            $table->longText('trailer_number');
            $table->longText('weight_lb');
            $table->longText('weight_kg');
            $table->longText('void_date');
            $table->longText('transportation_mode');
            $table->longText('tour_id');
            $table->longText('total_distance_km');
            $table->longText('shipper_load_number');
            $table->longText('routing_guide_first_carrier_carrier_reference');
            $table->longText('routing_guide');
            $table->longText('routed_date_used');
            $table->longText('required_equipment_short_description');
            $table->longText('required_equipment');
            $table->longText('related_order_identifiers');
            $table->longText('purchase_price');
            $table->longText('profit_or_loss_pct');
            $table->longText('priority');
            $table->longText('pieces_sum');
            $table->longText('pieces_max');
            $table->longText('pieces');
            $table->longText('matched_routing_guide');
            $table->longText('load_websettle_hold_status');
            $table->longText('load_reference_numbers');
            $table->longText('load_profit_loss_amount');
            $table->longText('load_group');
            $table->longText('load_contact');
            $table->longText('linear_space_m');
            $table->longText('linear_space_ft');
            $table->longText('last_drop_original_plan_date_end');
            $table->longText('last_drop_location_reference_number');
            $table->longText('last_drop_location_city');
            $table->longText('last_drop_has_pod');
            $table->longText('last_drop_calculated_date');
            $table->longText('last_drop_arrival_date');
            $table->longText('intermediate_stops');
            $table->longText('first_routing_guide_carrier_base_rate');
            $table->longText('first_pick_original_plan_date_end');
            $table->longText('first_pick_location_reference_number');
            $table->longText('first_pick_location_city');
            $table->longText('first_pick_has_pod');
            $table->longText('first_pick_eta_date');
            $table->longText('first_pick_departure_date');
            $table->longText('first_pick_calculated_due_date_indicator');
            $table->longText('first_pick_calculated_date');
            $table->longText('first_pick_appt_start_date');
            $table->longText('first_pick_appt_scheduled_date');
            $table->longText('first_pick_appointment_requested_date');
            $table->longText('division');
            $table->longText('data_mart_update_date');
            $table->longText('carrier_rank_when_tendered');
            $table->longText('first_pick_appointment_confirmed_date');
            $table->longText('last_drop_eta_date');
            $table->longText('last_drop_departure_date');
            $table->longText('websettle_batch_name');
            $table->longText('carrier_rate_modified');
            $table->longText('carrier_vendor_number');
            $table->longText('creation_process');
            $table->longText('driver_name2');
            $table->longText('execution_plan_rank');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('load_performances');
    }
}
