<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class dloa_transport extends Model
{
    use SoftDeletes;

    protected $table = 'dloa_transports';
    public $incrementing = true;
    protected $fillable = [
        'id_loa',
        'unit',
        'kapasitas',
        'rute_start',
        'rute_start_cross_relation',
        'rute_end',
        'rute_end_cross_relation',
        'rate',
        'multidrop',
        'loading',
        'overnight',
        'otherName',
        'otherRate',
    ];
}
