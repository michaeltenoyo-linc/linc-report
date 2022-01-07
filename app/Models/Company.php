<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $table = 'companies';
    protected $primaryKey = 'reference';
    public $incrementing = false;
    protected $fillable = [
        'reference',
        'location',
        'address_1',
        'address_2',
        'address_3',
        'country',
        'urban',
        'district',
        'city',
        'province',
        'postal_code',
        'timezone',
        'latitude',
        'longitude',
    ];
}
