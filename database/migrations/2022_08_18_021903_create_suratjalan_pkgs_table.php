<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratjalanPkgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suratjalan_pkg', function (Blueprint $table) {
            $table->string('posto')->primary();
            $table->float('qty',12);
            $table->date('terbit');
            $table->date('expired');
            $table->string('produk');
            $table->string('tujuan');
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
        Schema::dropIfExists('suratjalan_pkg');
    }
}
