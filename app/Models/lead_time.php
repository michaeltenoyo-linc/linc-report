<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lead_time extends Model
{
    protected $table = 'lead_times';
    protected $primaryKey = 'rg';
    public $incrementing = false;
    protected $fillable = [
        'rg',
        'rg_origin',
        'rg_destination',
        'cluster',
        'ltpod'
    ];
}
