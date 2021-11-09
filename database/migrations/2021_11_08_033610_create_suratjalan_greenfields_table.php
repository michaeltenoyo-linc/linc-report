<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratjalanGreenfieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suratjalan_greenfields', function (Blueprint $table) {
            $table->string('no_order')->primary();
            $table->date('order_date');
            $table->integer('qty');
            $table->string('destination');
            $table->float('other',12);
            $table->float('multidrop',12);
            $table->float('unloading',12);
            $table->string('note');
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
        Schema::dropIfExists('suratjalan_greenfields');
    }
}
