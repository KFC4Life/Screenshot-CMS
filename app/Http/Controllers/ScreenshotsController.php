<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\Screenshot;
use App\Models\Log;
use App\Models\Setting;

class ScreenshotsController extends Controller
{
    /*
     * Construct
     *
     * */
    public function __construct()
    {
        $this->middleware('auth:web')->except(['upload', 'get', 'getRaw']);
    }

    /*
     * Show recent screenshots
     *
     * */
    public function indexRecent()
    {
        $screenshots = DB::table('screenshots')->latest()->paginate(10);
        return view('screenshots_recent', compact('screenshots'));
    }

    /*
     * Show a screenshots overview
     *
     * */
    public function indexOverview()
    {
        $screenshots = DB::table('screenshots')->latest()->paginate(15);
        return view('screenshots_overview', compact('screenshots'));
    }

    /*
     * Upload a screenshot
     *
     * */
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $storage = storage_path('app/public/screenshots');
        $upload_key = $request->key;
        if($upload_key == Setting::where('name', 'upload_key')->first()->value) {

            // Check if file already exists
            if(File::exists(storage_path('app/public/screenshots/'.$file->getClientOriginalName()))) {
                // When exists return error 500 with file already exists message.
                abort(500, 'Sorry, a screenshot with that name does already exist, please try again.');
            } else {
                // Insert screenshot into database
                $screenshot = Screenshot::create([
                    'name' => $file->getFilename(),
                    'type' => $file->getMimeType(),
                ]);

                Log::create([
                    'event' => 'upload',
                    'ip' => request()->ip(),
                    'info' => 'File upload - '.$screenshot->name.' ('. $screenshot->type .')',
                ]);

                // Move uploaded file to storage directory.
                $file->move($storage,$file->getClientOriginalName());

                return route('screenshot.get', $screenshot->name);
            }
        } else {
            abort(500, 'Sorry, Invalid key.');
        }
    }

    public function get(Request $request)
    {
        $name = $request->name;

        $screenshot = Screenshot::where('name', '=', $name)->first();

        switch ($screenshot->type) {
            case 'image/jpeg':
                $full_name = $screenshot->name.'.jpg';
                break;
            case 'image/png':
                $full_name = $screenshot->name.'.png';
                break;
            case 'image/gif':
                $full_name = $screenshot->name.'.gif';
                break;
        }

        return view('screenshot', compact('screenshot', 'full_name'));
    }

    function getRaw(Request $request)
    {
            $name = $request->name;

            $path_png = '/app/public/screenshots/'. $name .'.png';
            $path_jpg = '/app/public/screenshots/'.$name.'.jpg';
            $path_gif = '/app/public/screenshots/'.$name.'.gif';

            if(File::exists(storage_path($path_png))) {
                $file = File::get(storage_path($path_png));
                $type = File::mimeType(storage_path($path_png));

                $response = Response::make($file, 200);
                $response->header("Content-Type", $type);

                return $response;
            } elseif(File::exists($path_jpg)) {
                $file = File::get($path_jpg);
                $type = File::mimeType($path_jpg);

                $response = Response::make($file, 200);
                $response->header("Content-Type", $type);

                return $response;
            } elseif(File::exists($path_gif)) {
                $file = File::get($path_gif);
                $type = File::mimeType($path_gif);

                $response = Response::make($file, 200);
                $response->header("Content-Type", $type);

                return $response;
            }
    }
}
