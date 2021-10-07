<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trucks extends Model
{
    use SoftDeletes;

    protected $table = 'trucks';
    protected $primaryKey = 'nopol';
    public $incrementing = false;
    protected $fillable = [
        'nopol',
        'fungsional',
        'ownership',
        'owner',
        'type',
        'v_gps',
        'site',
        'area',
        'taken',
        'kategori'
    ];
}
