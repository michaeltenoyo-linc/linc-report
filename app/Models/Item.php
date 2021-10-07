<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $table = 'items';
    protected $primaryKey = 'material_code';
    public $incrementing = false;
    protected $fillable = [
        'material_code',
        'description',
        'gross_weight',
        'nett_weight',
        'category'
    ];
}
