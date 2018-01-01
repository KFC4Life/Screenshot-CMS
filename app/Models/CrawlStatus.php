<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrawlStatus extends Model
{
    protected $table = 'crawl_status';

    protected $fillable = [
        ''
    ];

    public function screenshot()
    {
        $this->belongsTo('App\Models\Screenshot');
    }
}
