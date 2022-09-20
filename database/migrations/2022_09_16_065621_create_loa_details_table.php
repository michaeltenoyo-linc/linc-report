<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoaDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loa_detail', function (Blueprint $table) {
            $table->string('name');
            $table->string('id_loa');
            $table->primary(['name', 'id_loa']);
            $table->float('cost', 12);
            $table->string('qty');
            $table->string('duration');
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
        Schema::dropIfExists('loa_detail');
    }
}
