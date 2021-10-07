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
        'total_weightSO',
        'penerima',
        'utilitas',
        'biaya_bongkar',
        'tgl_muat',
        'total_qtySO',
    ];
}
