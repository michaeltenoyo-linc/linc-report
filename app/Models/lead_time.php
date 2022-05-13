<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lead_time extends Model
{
    protected $table = 'lead_times';
    public $incrementing = true;
    protected $fillable = [
        'route_guide',
        'cluster',
        'ltpod'
    ];
}
