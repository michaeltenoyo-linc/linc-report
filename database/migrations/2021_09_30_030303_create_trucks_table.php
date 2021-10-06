<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->string('nopol',10)->primary();
            $table->string('fungsional');
            $table->string('ownership');
            $table->string('owner');
            $table->string('type');
            $table->string('v_gps');
            $table->string('site');
            $table->string('area');
            $table->tinyInteger('taken')->default(0);
            $table->float('kategori',12)->nullable();
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
        Schema::dropIfExists('trucks');
    }
}
