<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class unit_surabaya extends Model
{
    protected $table = 'unit_surabaya';
    protected $primaryKey = 'nopol';
    public $incrementing = false;
    protected $fillable = [
        'nopol',
        'type',
        'customer',
        'driver',
        'own'
    ];
}
