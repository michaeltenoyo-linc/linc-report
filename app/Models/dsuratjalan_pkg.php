<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class dsuratjalan_pkg extends Model
{
    use softDeletes;
    protected $table = 'dsuratjalan_pkg';
    protected $primaryKey = 'load_id';
    public $incrementing = false;
    protected $fillable = [
        'load_id',
        'posto',
        'booking_code'
    ];
}
