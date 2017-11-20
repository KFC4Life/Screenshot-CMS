<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Screenshot;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $updated_at = Setting::where('name', 'upload_key')->first()->updated_at;
        $screenshots = Screenshot::all();
        if(!$screenshots->isEmpty()) {
            $last_added_id = DB::table('screenshots')->latest()->first()->id;
            $last_added = Screenshot::find($last_added_id)->created_at;
            $last_added_empty = false;
            return view('dashboard', compact('updated_at', 'last_added', 'last_added_empty'));
        } else {
            $last_added_empty = true;
            return view('dashboard', compact('updated_at', 'last_added_empty'));
        }
    }
}
