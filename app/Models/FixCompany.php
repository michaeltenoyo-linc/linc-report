<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixCompany extends Model
{
    protected $table = 'fix_companies';
    protected $primaryKey = 'reference';
    public $incrementing = false;
    protected $fillable = [
        'reference',
        'revision'
    ];
}
