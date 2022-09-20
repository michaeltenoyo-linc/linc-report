<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoaDetail extends Model
{
    protected $table = 'loa_detail';
    protected $primaryKey = ['name', 'id_loa'];
    public $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'name',
        'id_loa',
        'cost',
        'qty',
        'duration',
    ];

    protected function setKeysForSaveQuery(Builder $query)
    {
        return $query->where('name', $this->getAttribute('name'))
            ->where('id_loa', $this->getAttribute('id_loa'));
    }
}
