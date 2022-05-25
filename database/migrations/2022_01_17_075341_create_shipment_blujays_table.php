<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentBlujaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_blujays', function (Blueprint $table) {
            $table->string('order_number')->primary();
            $table->string('customer_reference');
            $table->string('customer_name');
            $table->string('load_id');
            $table->string('load_group');
            $table->float('billable_total_rate',12);
            $table->float('payable_total_rate',12);
            $table->date('load_closed_date')->nullable();
            $table->string('load_status');
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
        Schema::dropIfExists('shipment_blujays');
    }
}
