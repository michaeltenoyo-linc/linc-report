<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckType extends Model
{
    protected $table = 'truck_types';
    protected $primaryKey = 'reference';
    public $incrementing = false;
    protected $fillable = [
        'reference',
        'short',
        'type',
        'min_weight',
        'max_weight',
        'integration',
        'status'
    ];
}
