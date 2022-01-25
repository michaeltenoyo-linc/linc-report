<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratjalansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suratjalan', function (Blueprint $table) {
            $table->string('id_so')->primary();
            $table->string('load_id');
            $table->float('total_weightSO',12);
            $table->float('total_qtySO',12);
            $table->string('nopol');
            $table->string('penerima');
            $table->string('customer_type');
            $table->string('driver_nmk');
            $table->string('driver_name');
            $table->string('note');
            $table->float('utilitas');
            $table->float('biaya_bongkar',12);
            $table->float('biaya_overnight',12);
            $table->float('biaya_multidrop',12);
            $table->timestamp('tgl_terima');
            $table->timestamp('tgl_setor_sj')->nullable();
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
        Schema::dropIfExists('suratjalan');
    }
}
