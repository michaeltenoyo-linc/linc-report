<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suratjalan_ltl extends Model
{
    use softDeletes;
    protected $table = 'suratjalan_ltl';
    protected $primaryKey = ['id_so','no_do'];
    public $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id_so',
        'no_do',
        'load_id',
        'lokasi_pengiriman',
        'customer_name',
        'total_weightSO',
        'total_qtySO',
        'biaya_bongkar',
        'biaya_multidrop',
        'delivery_date'
    ];

    protected function setKeysForSaveQuery(Builder $query)
    {
        return $query->where('id_so', $this->getAttribute('id_so'))
                    ->where('no_do', $this->getAttribute('no_do'));
    }
}
