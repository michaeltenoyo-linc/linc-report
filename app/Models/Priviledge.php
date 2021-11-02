<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Priviledge extends Model
{
    use SoftDeletes;

    protected $table = 'priviledges';
    protected $fillable = [
        'user_id',
        'priviledge'
    ];
}
