<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->string('reference')->primary();
            $table->string('name');
            $table->string('status');
            $table->longText('address1');
            $table->longText('address2');
            $table->longText('address3');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('country');
            $table->string('timezone');
            $table->string('parent_customer');
            $table->string('default_freight_terms');
            $table->string('freight_billable_party');
            $table->string('supports_billable_rating');
            $table->string('supports_manual_billable_rate');
            $table->longText('billable_methods');
            $table->string('default_billable_method');
            $table->string('default_trans_currency');
            $table->string('bill_canadian_taxes');
            $table->string('bill_value_added_taxes');
            $table->string('support_billable_invoicing');
            $table->string('required_pod');
            $table->string('shipment_consolidation');
            $table->string('geography_consolidation');
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
        Schema::dropIfExists('customers');
    }
}
