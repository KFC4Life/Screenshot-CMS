<?php

namespace App\Http\Controllers;

use App\Models\Screenshot;
use Charts;

class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index()
    {
        $years = Screenshot::selectRaw('year(created_at) year')->groupBy('year')->get();
        $charts = [];

        foreach ($years as $year) {
            $charts[$year->year] = Charts::database(Screenshot::all(), 'line', 'highcharts')
                ->dimensions(0, 400)
                ->dateColumn('created_at')
                ->title('Screenshots per month ('. $year->year .')')
                ->elementLabel("Amount")
                ->responsive(true)
                ->groupByMonth($year->year);
        }

        return view('statistics', compact([
            'charts', 'years'
        ]));
    }
}
