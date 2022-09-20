<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratjalanLtlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suratjalan_ltl', function (Blueprint $table) {
            $table->string('id_so');
            $table->string('no_do');
            $table->primary(['id_so', 'no_do']);
            $table->string('load_id');
            $table->string('lokasi_pengiriman');
            $table->string('customer_name');
            $table->float('total_weightSO', 12);
            $table->float('total_qtySO', 12);
            $table->float('biaya_bongkar', 12);
            $table->float('biaya_multidrop', 12);
            $table->date('delivery_date');
            $table->longText('note');
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
        Schema::dropIfExists('suratjalan_ltls');
    }
}
