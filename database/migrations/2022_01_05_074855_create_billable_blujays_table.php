<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillableBlujaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billable_blujays', function (Blueprint $table) {
            $table->id();
            $table->string('billable_tariff');
            $table->string('billable_subtariff');
            $table->string('division');
            $table->string('order_group');
            $table->string('equipment');
            $table->string('allocation_method');
            $table->string('tier');
            $table->string('all_inclusive');
            $table->string('precedence');
            $table->string('origin_location');
            $table->string('destination_location');
            $table->string('no_intermediate_stop');
            $table->string('basis');
            $table->string('sku');
            $table->float('rate',12);
            $table->string('currency');
            $table->date('effective_date');
            $table->date('expiration_date');
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
        Schema::dropIfExists('billable_blujays');
    }
}
