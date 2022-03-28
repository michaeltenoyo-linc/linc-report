<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loa_transport extends Model
{
    use SoftDeletes;

    protected $table = 'loa_transports';
    public $incrementing = true;
    protected $fillable = [
        'customer',
        'cross_customer_reference',
        'lokasi',
        'periode_start',
        'periode_end',
        'files',
    ];
}
