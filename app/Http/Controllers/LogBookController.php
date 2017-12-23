<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogBookController extends Controller
{
    public function index()
    {
        $log = Log::orderBy('created_at', 'DESC')->paginate(15);
        return view('logbook', compact([
            'log'
        ]));
    }
}
