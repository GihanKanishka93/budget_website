<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEnd\PaymentController;
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
    return view('frontend.home');
});

Route::get('/payment', 'PaymentController@payment');
Route::get('/createPayment', 'App\Http\Controllers\FrontEnd\PaymentController@createPayment')->name('createPayment');
Route::get('/payment-success', 'App\Http\Controllers\FrontEnd\PaymentController@paymentSuccess')->name('payment-success');
Route::get('payment-failure', 'App\Http\Controllers\FrontEnd\PaymentController@paymentFailure');
Route::post('/payment-response', 'App\Http\Controllers\FrontEnd\PaymentController@handlePaymentResponse');