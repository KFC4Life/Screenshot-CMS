<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/v1')->group(function () {
    Route::get('/', function () {
        return 'This is the Screenshot CMS API, for documentation please visit the repo wiki.';
    });

   Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
