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

//payment processing
Route::prefix('payment')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/process', 'PaymentController@processPayment');
        //callback route for payment gateway

    });
    Route::get('/callback', 'PaymentController@paymentCallback');
});
