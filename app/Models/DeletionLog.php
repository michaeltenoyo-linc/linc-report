<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeletionLog extends Model
{
    protected $table = 'deletion_logs';
    public $incrementing = true;
    protected $fillable = [
        'table',
        'delete_id',
        'user'
    ];
}
