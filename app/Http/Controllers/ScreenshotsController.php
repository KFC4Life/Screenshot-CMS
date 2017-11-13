<?php

namespace App\Controllers;

use Illuminate\Http\Request;

class ScreenshotsController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:web');
    }

    public function indexRecent()
    {
        return view('screenshots');
    }
    public function indexOverview()
    {
        return view('screenshots');
    }
}
