<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LoaDetailBp extends Model
{
    protected $table = 'loa_detail_bp';
    protected $primaryKey = ['name', 'id_loa'];
    public $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'name',
        'id_loa',
        'cost',
        'uom',
        'terms',
        'type',
    ];

    protected function setKeysForSaveQuery(Builder $query)
    {
        return $query->where('name', $this->getAttribute('name'))
            ->where('id_loa', $this->getAttribute('id_loa'));
    }
}
