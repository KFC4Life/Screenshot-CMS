<?php

namespace App\Http\Controllers;

use App\Models\Screenshot;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Validator;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware('role:admin')->except([
            'index',
            'generateKey',
            'setWebHooks',
            'updateAccount',
            'updateAccountPassword',
            'updateDarkTheme',
        ]);
    }

    public function index()
    {
        return view('settings');
    }

    /*
     * Generate a new upload key
     *
     * */
    public function generateKey(Request $request)
    {
        $key = str_random(20);

        Auth::user()->update([
            'api_token' => $key,
        ]);

        return back()->with([
            'msg' => 'Succesfully generated a new API key, Yay!'
        ]);
    }

    public function setWebHooks(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slack_webhook_url' => 'nullable|url',
            'discord_webhook_url' => 'nullable|url',
        ])->validate();

        $user = User::find(Auth::id());

        $user->slack_webhook_url = $request->input('slack_webhook_url');
        $user->discord_webhook_url = $request->input('discord_webhook_url');

        $user->save();

        Session::flash('success', 'Succesfully updated webhook urls, Yay!');

        return back();
    }

    public function users()
    {
        $users = User::all();
        return view('settings.users', compact('users'));
    }

    public function storeUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ])->validate();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'api_token' => str_random(20),
        ]);

        if($request->role == 'admin') {
            $user->assignRole('admin');
        }

        Session::flash('success', 'User succesfully created!');

        return redirect()->back();
    }

    public function updateAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|string',
            'email' => 'required|max:255|email|unique:users,email,'.Auth::id(),
        ])->validate();

        $user = User::find(Auth::id());
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        Session::flash('success', 'Account succesfully updated!');

        return redirect()->back();
    }

    public function updateAccountPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|confirmed',
        ])->validate();

        $user = User::find(Auth::id());
        $user->password = Hash::make($request->input('password'));
        $user->save();

        Session::flash('success', 'Account password succesfully updated!');

        return redirect()->back();
    }

    public function editUser(User $user)
    {
        if($user->id == Auth::id()) {
            Session::flash('danger', 'You can\'t edit your own profile in the admin area. Please do this on the personal settings page.');

            return redirect()->route('settings.users');
        }

        return view('settings.users.edit', compact('user'));
    }

    public function updateUser(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|string',
            'email' => 'required|max:255|email|unique:users,email,'.$user->id,
            'role' => 'required|in:user,admin',
        ])->validate();

        $user = User::find($user->id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        if($request->input('role') == 'admin') {
            if($user->isAdmin() !== true) {
                $user->assignRole('admin');
            }
        } elseif($request->input('role') == 'user') {
            if($user->isAdmin() == true) {
                $user->removeRole('admin');
            }
        }

        Session::flash('success', 'User succesfully edited!');

        return redirect()->route('settings.users');
    }

    public function deleteUser(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files_destination' => 'required|in:deleted,account'
        ]);

        $validator->sometimes('migration_user', [
            'required',
            Rule::in(User::where('id', '!=', $user->id)->pluck('id')),
        ], function ($input) {
            return $input->files_destination == 'account';
        });

        $validator->validate();

        if ($request->files_destination == 'account') {
            $screenshots = Screenshot::where('user_id', '=', $user->id)
                ->update([
                    'user_id' => $request->migration_user,
                ]);
        } else {
            $screenshots = Screenshot::where('user_id', '=', $user->id)
                ->get();

            foreach ($screenshots as $screenshot) {
                $screenshot->delete();
            }
        }

        $user->delete();

        Session::flash('success', 'User succesfully deleted!');

        return redirect()->route('settings.users');
    }
    public function updateDarkTheme(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dark_theme' => 'required|in:0,1'
        ])->validate();

        $user = User::find(Auth::id());
        $user->dark_theme_status = $request->dark_theme;
        $user->save();

        Session::flash('success', 'Dark theme settings successfully updated!');

        return back();
    }
}
