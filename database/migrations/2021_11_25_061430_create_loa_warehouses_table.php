<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoaWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loa_warehouse', function (Blueprint $table) {
            $table->id();
            $table->date('periode_start');
            $table->date('periode_end');
            $table->float('jasa_titip');
            $table->float('handling_in');
            $table->float('handling_out');
            $table->float('rental_pallete');
            $table->float('loading');
            $table->float('unloading');
            $table->float('management');
            $table->longText('other_name');
            $table->longText('other_rate');
            $table->longText('uom');
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
        Schema::dropIfExists('loa_warehouses');
    }
}
