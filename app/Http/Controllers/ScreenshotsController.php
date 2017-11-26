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
        $storage = storage_path('app/public/screenshots');
        $file = $request->file('file');
        $upload_key = $request->key;
        $type = substr($file->getMimeType(), 0, 5);


        if($file == null) {
            return response()->json([
                'success' => false,
                'screenshot' => [],
                'error' => 'Please give a file to upload.',
            ], 500);
        } elseif($upload_key == null) {
            return response()->json([
                'success' => false,
                'screenshot' => [],
                'error' => 'Please give a key to validate.',
            ], 500);
        } elseif($type != 'image') {
            return response()->json([
                'success' => false,
                'screenshot' => [],
                'error' => 'File is not an image.',
            ], 500);
        } else {
            if($upload_key == Setting::where('name', 'upload_key')->first()->value) {
                // Check if file already exists
                if(File::exists(storage_path('app/public/screenshots/'.$file->getClientOriginalName()))) {
                    // When exists return error 500 with file already exists message.
                    return response()->json([
                        'success' => false,
                        'screenshot' => [],
                        'error' => 'File does already exists.',
                    ], 500);
                } else {
                    // Insert screenshot into database
                    switch($file->getMimeType()) {
                        case 'image/jpeg':
                            $new_name = str_random(7);
                            $new_full_name = $new_name.'.jpg';
                            break;
                        case 'image/png':
                            $new_name = str_random(7);
                            $new_full_name = $new_name.'.png';
                            break;
                        case 'image/gif':
                            $new_name = str_random(7);
                            $new_full_name = $new_name.'.gif';
                            break;
                        default:
                            return response()->json([
                                'success' => false,
                                'screenshot' => [],
                                'error' => 'Unknown error'
                            ]);
                            break;
                    }

                    $screenshot = Screenshot::create([
                        'name' => $new_name,
                        'type' => $file->getMimeType(),
                        'full_name' => $new_full_name,
                    ]);

                    Log::create([
                        'event' => 'upload',
                        'ip' => request()->ip(),
                        'info' => 'File upload - '.$screenshot->name.' ('. $screenshot->type .')',
                    ]);

                    // Move uploaded file to storage directory.
                    $file->move($storage,$new_full_name);

                    // TODO: ADD DELETE URL IN RESPONSE

                    return response()->json([
                        'success' => true,
                        'screenshot' => [
                            'url' => route('screenshot.get', $screenshot->name),
                        ],
                        'error' => '',
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'screenshot' => [],
                    'error' => 'Invalid key!',
                ], 500);
            }
        }
    }

    public function get(Request $request)
    {
        $screenshot = Screenshot::where('name', '=', $request->name)->first();
        if(!$screenshot == null) {
            return view('screenshot', compact('screenshot'));
        } else {
            return view('errors.screenshot_not_found');
        }
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
