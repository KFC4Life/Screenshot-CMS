<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('landing');
});

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::as('screenshots.')->group(function () {
    Route::get('/screenshots/recent', 'ScreenshotsController@indexRecent')->name('recent');
    Route::get('/screenshots/overview', 'ScreenshotsController@indexOverview')->name('overview');
});

Route::get('/screenshots/upload', 'ScreenshotsController@viewUpload')->name('screenshots.upload');
Route::post('/screenshots/upload', 'ScreenshotsController@upload')->name('screenshots.upload');

Route::get('/settings', 'SettingsController@index')->name('settings');
Route::post('/settings/key/generate', 'SettingsController@generateKey')->name('settings.key.generate');

Route::get('/logbook', 'LogBookController@index')->name('logbook');

// Authentication Routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::domain(env('APP_URL'))->get('/{name}', 'ScreenshotsController@get')->name('screenshot.get');
Route::domain(env('APP_URL'))->get('/raw/{name}', 'ScreenshotsController@getRaw')->name('screenshot.get.raw');