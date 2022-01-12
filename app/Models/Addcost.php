<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addcost extends Model
{
    use SoftDeletes;

    protected $table = 'addcosts';
    public $incrementing = true;
    protected $fillable = [
        'load_id',
        'rate',
        'type'
    ];
}
