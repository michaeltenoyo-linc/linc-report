<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loa_bulk extends Model
{
    use SoftDeletes;

    protected $table = 'loa_bulks';
    public $incrementing = true;
    protected $fillable = [
        'customer',
        'lokasi',
        'periode_start',
        'periode_end',
        'files',
    ];
}
