<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoaMaster extends Model
{
    protected $table = 'loa_masters';
    public $incrementing = true;
    protected $fillable = [
        'name',
        'effective',
        'expired',
        'id_customer',
        'type'
    ];
}
