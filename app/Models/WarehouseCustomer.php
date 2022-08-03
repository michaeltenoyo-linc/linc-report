<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseCustomer extends Model
{

    protected $table = 'warehouse_customers';
    protected $primaryKey = 'customer_number';
    public $incrementing = false;
    protected $fillable = [
        'customer_number',
        'customer_description',
        'customer_sap'
    ];
}
