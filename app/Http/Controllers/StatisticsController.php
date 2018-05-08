<?php

namespace App\Http\Controllers;

use App\Models\Screenshot;
use Charts;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:web',
            'role:admin'
        ]);
    }

    public function index()
    {
        $file_size = 0;
        foreach(Storage::disk('local')->allFiles('/public/screenshots') as $file)
        {
            $file_size += Storage::disk('local')->size($file);
        }
        $file_size = number_format($file_size / 1048576,2);

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
            'charts', 'years', 'file_size'
        ]));
    }
}
