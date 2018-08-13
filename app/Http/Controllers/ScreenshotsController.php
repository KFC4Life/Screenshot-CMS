<?php

namespace App\Http\Controllers;

use App\Notifications\Notifications\NewScreenshotUploaded;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Screenshot;
use App\Models\Log;
use App\Models\Setting;
use Auth;
use Mockery\Exception;

class ScreenshotsController extends Controller
{
    /*
     * Construct
     *
     * */
    public function __construct()
    {
        // Protect functions with authentication
        $this->middleware('auth:web')->except([
            'upload',
            'get',
            'getRaw',
        ]);

        $this->middleware('role:admin')->except([
            'upload',
            'get',
            'getRaw',
            'indexMine',
            'destroy',
            'destroyPermanently',
            'restore',
            'indexTrash',
            'emptyTrash',
        ]);
    }

    /**
     * Show screenshots of the authenticated user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexMine()
    {
        $screenshots = Screenshot::where('user_id', '=', Auth::id())->latest()->simplePaginate(6);
        return view('screenshots', compact('screenshots'));
    }

    /**
     * Show all screenshots
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexAll()
    {
        $screenshots = Screenshot::latest()->simplePaginate(6);
        return view('screenshots', compact('screenshots'));
    }

    /**
     * Show deleted screenshots
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexTrash()
    {
        if(Session::get('show_others_trash')) {
            $screenshots = Screenshot::onlyTrashed()->latest('deleted_at')->simplePaginate(6);
        } else {
            $screenshots = auth()->user()->screenshots()->onlyTrashed()->latest('deleted_at')->simplePaginate(6);
        }

        return view('screenshots', compact('screenshots'));
    }

    public function ShowOthersTrashSwitch(Request $request)
    {
        if($request->show_others_trash) {
            Session::flash('show_others_trash', 1);
        } else {
            Session::flash('show_others_trash', 0);
        }

        return back();
    }

    /**
     * Delete a screenshot
     *
     * @param Screenshot $screenshot
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($screenshot)
    {
        $sc = Screenshot::where('name', '=', $screenshot)
                ->first();

        if($sc == null) {
            return back();
        }

        Log::create([
            'event' => 'delete',
            'ip' => request()->ip(),
            'info' => 'File deleted - '.$sc->first()->name.' ('. $sc->type .')',
        ]);

        $sc->delete();

        Session::flash('success', 'Screenshot succesfully deleted.');

        return redirect()->back();
    }

    /**
     * Delete a screenshot permanently
     *
     * @param $screenshot
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyPermanently($screenshot)
    {
        $sc = Screenshot::onlyTrashed()
            ->where('name', '=', $screenshot)
            ->first();

        if($sc == null) {
            return back();
        }

        Storage::disk('local')->delete('public/screenshots/'.$sc->full_name);

        Log::create([
            'event' => 'permanently-delete',
            'ip' => request()->ip(),
            'info' => 'File permanently deleted - '.$sc->name.' ('. $sc->type .')',
        ]);

        $sc->forceDelete();

        Session::flash('success', 'Screenshot succesfully force deleted.');

        return redirect()->route('screenshots.trash');
    }

    /**
     * Restore a deleted soft-deleted screenshot
     *
     * @param $screenshot
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($screenshot)
    {
        $sc = Screenshot::onlyTrashed()
            ->where('name', '=', $screenshot)
            ->first();

        Log::create([
            'event' => 'restore',
            'ip' => request()->ip(),
            'info' => 'File restored - '.$sc->name.' ('. $sc->type .')',
        ]);

        $sc->restore();

        Session::flash('success', 'Screenshot succesfully restored.');

        return back();
    }

    /**
     * Upload a screenshot
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $storage = storage_path('app/public/screenshots');
        $file = $request->file('file');
        $upload_key = $request->key;
        $type = substr($file->getMimeType(), 0, 5);


        if($file == null) {
            throw new \App\Exceptions\Screenshots\NoFileSpecifiedToUpload();
        } elseif($upload_key == null) {
            throw new \App\Exceptions\Screenshots\NoApiTokenSpecifiedToValidate();
        } elseif($type != 'image') {
            throw new \App\Exceptions\Screenshots\FileIsNotAnImage();
        } else {
            $keys = User::all()->makeVisible('api_token')->pluck('api_token')->toArray();
                if(in_array($upload_key, $keys)) {
                    // Check if file already exists
                    if(File::exists(storage_path('app/public/screenshots/'.$file->getClientOriginalName()))) {
                        // When exists throw exception
                        throw new \App\Exceptions\Screenshots\FileAlreadyExists();
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
                                throw new \App\Exceptions\Screenshots\FileTypeNotSupported();
                                return response()->json([
                                    'success' => false,
                                    'screenshot' => [],
                                    'error' => 'We don\'t support that file type!',
                                ]);
                                break;
                        }

                        $user = User::where('api_token', '=', $upload_key)
                            ->first();

                        $screenshot = new Screenshot;
                        $screenshot->name = $new_name;
                        $screenshot->type = $file->getMimeType();
                        $screenshot->full_name = $new_full_name;
                        $screenshot->user_id = $user->id;
                        $screenshot->save();

                        Log::create([
                            'event' => 'upload',
                            'ip' => request()->ip(),
                            'info' => 'File upload - '.$screenshot->name.' ('. $screenshot->type .')',
                        ]);

                        // Move uploaded file to storage directory.
                        $file->move($storage,$new_full_name);

                        if($user->slack_webhook_url != null || $user->discord_webhook_url != null) {
                            $user->notify(new NewScreenshotUploaded($screenshot));
                        }

                        // TODO: ADD DELETE URL IN RESPONSE

                        return response()->json([
                            'success' => true,
                            'screenshot' => [
                                'url' => route('screenshot.get', [
                                    $screenshot->name,
                                ]),
                                'delete_url' => 'Use the web UI please.',
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

    public function get(Request $request, $name)
    {
        if($screenshot = Screenshot::where('name', '=', $name)->first()) {
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

    public function emptyTrash()
    {
        $user = auth()->user();

        $screenshots = auth()->user()->screenshots()->onlyTrashed()->forceDelete();

        Session::flash('success', 'Trash succesfully emptied.');

        return back();
    }
}
