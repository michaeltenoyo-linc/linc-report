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
            $table->string('tms_id',20)->primary();
            $table->datetime('created_date');
            $table->string('carrier_reference',20);
            $table->string('carrier_name');
            $table->string('equipment_description');
            $table->string('vehicle_number',10);
            $table->string('load_status',50);
            $table->string('first_pick_location_name');
            $table->string('last_drop_location_name');
            $table->string('routing_guide_name');
            $table->float('payable_total_rate',12);
            $table->float('billable_total_rate',12);
            $table->datetime('closed_date')->nullable();
            $table->float('weight_lb',12);
            $table->float('weight_kg',12);
            $table->float('total_distance_km');
            $table->string('routing_guide');
            $table->string('load_group');
            $table->string('load_contact');
            $table->string('last_drop_location_reference_number');
            $table->string('last_drop_location_city');
            $table->string('first_pick_location_reference_number');
            $table->string('first_pick_location_city');
            $table->string('customer_reference');
            $table->longText('customer_name');
            $table->datetime('websettle_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
