<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class postal_code extends Model
{
    protected $table = 'postal_codes';
    public $incrementing = true;
    protected $fillable = [
        'province',
        'city',
        'district',
        'urban',
        'postal_code',
    ];
}
