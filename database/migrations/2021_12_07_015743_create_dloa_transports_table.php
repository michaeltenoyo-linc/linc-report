<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDloaTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dloa_transports', function (Blueprint $table) {
            $table->id();
            $table->integer('id_loa');
            $table->string("unit");
            $table->float("kapasitas",12);
            $table->string("rute_start");
            $table->string("rute_end");
            $table->float("rate",12);
            $table->float("multidrop",12);
            $table->float("overnight",12);
            $table->float("loading",12);
            $table->longText("otherName");
            $table->longText("otherRate");
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
        Schema::dropIfExists('dloa_transports');
    }
}
