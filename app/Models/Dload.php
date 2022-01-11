<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dload extends Model
{
    use SoftDeletes;

    protected $table = 'dload';
    protected $fillable = [
        'id_so',
        'nopol',
        'material_code',
        'qty',
        'retur',
        'subtotal_weight'
    ];
}
