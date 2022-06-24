<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoaFile extends Model
{
    protected $table = 'loa_files';
    public $incrementing = true;
    protected $fillable = [
        'id_loa',
        'filename',
        'extension'
    ];
}
