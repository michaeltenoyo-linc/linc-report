<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillableBlujay extends Model
{
    use SoftDeletes;

    protected $table = 'billable_blujays';
    public $incrementing = true;
    protected $fillable = [
        'billable_tariff',
        'billable_subtariff',
        'customer_reference',
        'division',
        'order_group',
        'equipment',
        'allocation_method',
        'tier',
        'all_inclusive',
        'precedence',
        'origin_location',
        'destination_location',
        'origin_city',
        'destination_city',
        'no_intermediate_stop',
        'basis',
        'sku',
        'rate',
        'currency',
        'effective_date',
        'expiration_date',
    ];
}
