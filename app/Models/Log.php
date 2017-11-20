<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'event', 'ip', 'info',
    ];

    protected $table = 'log';
}
