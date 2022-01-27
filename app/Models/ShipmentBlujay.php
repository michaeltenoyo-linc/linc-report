<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipmentBlujay extends Model
{
    use softDeletes;
    protected $table = 'shipment_blujays';
    protected $primaryKey = 'order_number';
    public $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'order_number',
        'customer_reference',
        'customer_name',
        'load_id',
        'load_group',
        'billable_total_rate',
        'load_closed_date',
        'load_status',
    ];
}
