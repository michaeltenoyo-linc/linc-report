<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoaDetailBpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loa_detail_bp', function (Blueprint $table) {
            $table->string('name');
            $table->string('id_loa');
            $table->primary(['name', 'id_loa']);
            $table->float('cost', 12);
            $table->string('uom');
            $table->longText('terms');
            $table->string('type');
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
        Schema::dropIfExists('loa_detail_bp');
    }
}
