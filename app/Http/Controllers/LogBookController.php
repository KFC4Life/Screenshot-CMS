<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class LogBookController extends Controller
{
    /**
     * LogBookController constructor.
     */
    public function __construct()
    {
        $this->middleware([
            'auth:web',
            'role:admin',
        ]);
    }

    /**
     * Show the logbook
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $log = Log::orderBy('created_at', 'DESC')->paginate(15);
        return view('logbook', compact([
            'log'
        ]));
    }

    public function clear()
    {
        Artisan::call('logbook:clear');

        return back();
    }
}
