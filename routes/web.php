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

/*
|--------------------------------------------------------------------------
| Other routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
});
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/logbook', 'LogBookController@index')->name('logbook');
Route::post('/logbook/clear', 'LogBookController@clear')->name('logbook.clear');
Route::get('/statistics', 'StatisticsController@index')->name('statistics');

/*
|--------------------------------------------------------------------------
| Screenshot Routes
|--------------------------------------------------------------------------
*/
Route::as('screenshots.')->prefix('screenshots')->group(function () {
    Route::get('/', 'ScreenshotsController@indexMine')->name('mine');
    Route::get('/all', 'ScreenshotsController@indexAll')->name('all');
    Route::get('/trash', 'ScreenshotsController@indexTrash')->name('trash');
    Route::get('/upload', 'ScreenshotsController@viewUpload')->name('upload');
    Route::post('/upload', 'ScreenshotsController@upload')->name('upload');
    Route::delete('/{screenshot}/delete', 'ScreenshotsController@destroy')->name('destroy');
    Route::delete('/{screenshot}/delete/permanently', 'ScreenshotsController@destroyPermanently')->name('destroy.permanently');
    Route::put('/{screenshot}/restore', 'ScreenshotsController@restore')->name('restore');
});

/*
|--------------------------------------------------------------------------
| Setting Routes
|--------------------------------------------------------------------------
*/
Route::as('settings')->prefix('settings')->group(function () {
    // Setting routes
    Route::get('/', 'SettingsController@index');
    Route::as('.')->group(function () {
        Route::as('users')->prefix('users')->group(function () {
            Route::get('/', 'SettingsController@users');
            Route::post('/', 'SettingsController@storeUser');
            Route::as('.')->group(function () {
                Route::get('/{user}/edit', 'SettingsController@editUser')->name('edit');
                Route::put('/{user}/update', 'SettingsController@updateUser')->name('update');
                Route::delete('/{user}/delete', 'SettingsController@deleteUser')->name('delete');
            });
        });
        Route::put('/account/dark-theme/update', 'SettingsController@updateDarkTheme')->name('account.darktheme.update');
        Route::post('/account/api/key/generate', 'SettingsController@generateKey')->name('key.generate');
        Route::post('/slackwebhook/update', 'SettingsController@setSlackWebHookUrl')->name('slackwebhook.update');
        Route::put('/account/update', 'SettingsController@updateAccount')->name('account.update');
        Route::put('/account/password/update', 'SettingsController@updateAccountPassword')->name('account.password.update');
    });
});

/*
|--------------------------------------------------------------------------
| Authentication routes
|--------------------------------------------------------------------------
*/
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::domain(env('APP_URL'))->get('/{name}', 'ScreenshotsController@get')->name('screenshot.get')->middleware('CrawlerCheck');
Route::domain(env('APP_URL'))->get('/raw/{name}', 'ScreenshotsController@getRaw')->name('screenshot.get.raw');