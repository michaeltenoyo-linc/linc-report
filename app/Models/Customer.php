<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'customers';
    protected $primaryKey = 'reference';
    public $incrementing = false;
    protected $fillable = [
        'reference',
        'name',
        'status',
        'address1',
        'address2',
        'address3',
        'city',
        'state',
        'postal_code',
        'country',
        'timezone',
        'parent_customer',
        'default_freight_terms',
        'freight_billable_party',
        'supports_billable_rating',
        'supports_manual_billable_rate',
        'billable_methods',
        'default_billable_method',
        'default_trans_currency',
        'bill_canadian_taxes',
        'bill_value_added_taxes',
        'support_billable_invoicing',
        'required_pod',
        'shipment_consolidation',
        'geography_consolidation',
    ];
}
