<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoadPerformance extends Model
{
    use SoftDeletes;
    protected $table = 'load_performances';
    protected $primaryKey = 'tms_id';
    public $incrementing = false;
    protected $fillable = [
        'tms_id',
        'created_date',
        'carrier_reference',
        'carrier_name',
        'equipment_description',
        'vehicle_number',
        'load_status',
        'first_pick_location_name',
        'last_drop_location_name',
        'routing_guide_name',
        'payable_total_rate',
        'billable_total_rate',
        'closed_date',
        'weight_lb',
        'weight_kg',
        'total_distance_km',
        'routing_guide',
        'load_group',
        'load_contact',
        'last_drop_location_reference_number',
        'last_drop_location_city',
        'first_pick_location_reference_number',
        'first_pick_location_city',
        'customer_reference',
        'customer_name',
        'websettle_date',
    ];
}
