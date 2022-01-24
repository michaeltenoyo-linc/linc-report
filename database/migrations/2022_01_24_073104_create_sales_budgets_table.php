<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_budgets', function (Blueprint $table) {
            $table->id();
            $table->string('sales');
            $table->string('division');
            $table->string('customer_name');
            $table->string('customer_sap');
            $table->string('customer_status');
            $table->date('period');
            $table->float('budget',12);
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
        Schema::dropIfExists('sales_budgets');
    }
}
