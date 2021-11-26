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
            $table->float('jasa_titip',12);
            $table->float('handling_in',12);
            $table->float('handling_out',12);
            $table->float('rental_pallete',12);
            $table->float('loading',12);
            $table->float('unloading',12);
            $table->float('management',12);
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
