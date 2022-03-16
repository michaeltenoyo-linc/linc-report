<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillableMethod extends Model
{
    protected $table = 'billable_methods';
    protected $primaryKey = 'billable_method';
    public $incrementing = false;
    protected $fillable = [
        'billable_method',
        'cross_reference',
    ];
}
