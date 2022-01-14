<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerLtl extends Model
{
    use SoftDeletes;

    protected $table = 'customer_ltl';
    public $incrementing = true;
    protected $fillable = [
        'name',
    ];
}
