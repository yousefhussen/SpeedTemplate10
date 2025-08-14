<?php

use Illuminate\Http\Request;
use Modules\Auth\Http\Controllers\AuthenticatedSessionController;
use Modules\Profile\Http\Controllers\AddressController;
use Modules\Profile\Http\Controllers\WishlistController;

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

Route::prefix('profile')->group(function() {
    Route::get('/', 'ProfileController@index');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/wishlist', [WishlistController::class, 'store']);
        Route::get('/wishlist', [WishlistController::class, 'index']); // Retrieve wishlist items
        Route::delete('/wishlist/{item_id}', [WishlistController::class, 'destroy']); // Remove an item
        //get wishlist ids
        Route::get('/wishlist/ids', [WishlistController::class, 'getWishlistIds']);


        //cart
        Route::post('/cart', 'CartController@store');
        Route::get('/cart', 'CartController@index'); // Retrieve cart items
        Route::delete('/cart/{cartItemId}', 'CartController@destroy'); // Remove an item from the cart
        Route::put('/cart/{cartItemId}/decrease', 'CartController@decreaseQuantity'); // Decrease quantity of an item in the cart
        Route::put('/cart/{cartItemId}/increase', 'CartController@increaseQuantity'); // Increase quantity of an item in the cart

        //alter profile picture
        Route::post('/profile-picture', [AuthenticatedSessionController::class, 'updateProfilePicture'])
            ->middleware('auth:sanctum')
            ->name('profile.picture.update');


        // Address routes
        Route::get('/addresses', [AddressController::class, 'index']);
        Route::post('/addresses', [AddressController::class, 'store']);
        Route::put('/addresses/{id}', [AddressController::class, 'update']);
        Route::delete('/addresses/{id}', [AddressController::class, 'destroy']);


    });


});
