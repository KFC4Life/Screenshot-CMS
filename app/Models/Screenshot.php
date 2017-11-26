<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Screenshot extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'type', 'created_at', 'updated_at', 'full_name'
    ];
}
