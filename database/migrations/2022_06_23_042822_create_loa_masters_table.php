<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoaMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loa_masters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('effective');
            $table->date('expired');
            $table->string('id_customer');
            $table->tinyInteger('is_archived');
            $table->string('type');
            $table->string('group');
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
        Schema::dropIfExists('loa_masters');
    }
}
