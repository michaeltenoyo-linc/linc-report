<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dload', function (Blueprint $table) {
            $table->id();
            $table->string('id_so');
            $table->string('nopol',10);
            $table->string('material_code',6);
            $table->float('qty',10);
            $table->float('subtotal_weight',12);
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
        Schema::dropIfExists('dloads');
    }
}
