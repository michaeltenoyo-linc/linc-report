<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suratjalan_pkg extends Model
{
    use softDeletes;
    protected $table = 'suratjalan_pkg';
    protected $primaryKey = 'posto';
    public $incrementing = false;
    protected $fillable = [
        'posto',
        'qty',
        'terbit',
        'expired',
        'produk',
        'tujuan'
    ];
}
