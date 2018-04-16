<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index()
    {
        $upload_key = Setting::where('name', 'upload_key')->first()->value;

        return view('settings', compact('upload_key'));
    }

    /*
     * Generate a new upload key
     *
     * */
    public function generateKey(Request $request)
    {
        $key = str_random(20);
        $upload_key = Setting::where('name', 'upload_key')->first();
        $upload_key->value = $key;
        $upload_key->save();

        return back()->with([
            'msg' => 'Succesfully generated a new upload key, Yay!'
        ]);
    }

    public function setSlackWebHookUrl(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $user->slack_webhook_url = $request->input('slack_webhook_url');
        $user->discord_webhook_url = $request->input('discord_webhook_url');

        $user->save();

        return back()->with([
            'msg' => 'Succesfully updated webhook urls, Yay!'
        ]);
    }
}
