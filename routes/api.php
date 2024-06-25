<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('form-submit', 'App\Http\Controllers\API\ApiController@submitFrom');
Route::post('save-logo', 'App\Http\Controllers\API\ApiController@saveLogo');
Route::post('form-submit-update/{id}', 'App\Http\Controllers\API\ApiController@updateFrom');
