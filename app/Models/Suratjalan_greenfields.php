<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suratjalan_greenfields extends Model
{
    use softDeletes;
    protected $table = 'suratjalan_greenfields';
    protected $primaryKey = 'no_order';
    public $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'no_order',
        'load_id',
        'order_date',
        'qty',
        'destination',
        'other',
        'multidrop',
        'unloading',
        'note',
    ];
}
