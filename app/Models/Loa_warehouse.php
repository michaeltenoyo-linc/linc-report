<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loa_warehouse extends Model
{
    use SoftDeletes;

    protected $table = 'loa_warehouse';
    public $incrementing = true;
    protected $fillable = [
        'periode_start',
        'periode_end',
        'jasa_titip',
        'handling_in',
        'handling_out',
        'rental_pallete',
        'loading',
        'unloading',
        'management',
        'other_name',
        'other_rate',
        'uom'
    ];
}
