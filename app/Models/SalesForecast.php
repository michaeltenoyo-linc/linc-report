<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesForecast extends Model
{
    use softDeletes;
    protected $table = 'sales_forecasts';
    public $incrementing = true;
    protected $fillable = [
        'sales',
        'division',
        'customer_name',
        'customer_sap',
        'customer_status',
        'period',
        'forecast'
    ];
}
