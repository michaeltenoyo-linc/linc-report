<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suratjalan extends Model
{
    //

    use softDeletes;
    protected $table = 'suratjalan';
    protected $primaryKey = 'id_so';
    public $incrementing = false;
    protected $fillable = [
        'id_so',
        'load_id',
        'nopol',
        'driver_nmk',
        'driver_name',
        'total_weightSO',
        'penerima',
        'customer_type',
        'utilitas',
        'biaya_bongkar',
        'biaya_overnight',
        'biaya_multidrop',
        'tgl_terima',
        'total_qtySO',
        'note',
    ];
}
