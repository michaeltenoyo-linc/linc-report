<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suratjalan_ltl extends Model
{
    use softDeletes;
    protected $table = 'suratjalan_ltl';
    protected $primaryKey = 'id_so';
    public $incrementing = false;
    protected $fillable = [
        'id_so',
        'no_do',
        'load_id',
        'nopol',
        'lokasi_pengiriman',
        'kota_pengiriman',
        'total_weightSO',
        'total_qtySO',
        'biaya_bongkar',
        'biaya_multidrop',
        'delivery_date'
    ];
}
