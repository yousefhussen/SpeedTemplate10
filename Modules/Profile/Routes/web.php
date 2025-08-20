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


use Modules\Auth\Http\Controllers\AuthenticatedSessionController;
use Modules\Profile\Http\Controllers\AddressController;
use Modules\Profile\Http\Controllers\WishlistController;
use Modules\Profile\Http\Controllers\ProfileController;
use Modules\Profile\Http\Controllers\CartController;

Route::prefix('profile')->group(function() {
    Route::get('/', [ProfileController::class, 'index']);

    Route::middleware('auth')->group(function () {
        Route::post('/wishlist', [WishlistController::class, 'store']);
        Route::get('/wishlist', [WishlistController::class, 'index']); // Retrieve wishlist items
        Route::delete('/wishlist/{item_id}', [WishlistController::class, 'destroy']); // Remove an item
        //get wishlist ids
        Route::get('/wishlist/ids', [WishlistController::class, 'getWishlistIds']);
        Route::get('/wishlist/check/{productId}', [WishlistController::class, 'isInWishlist'])->name('wishlist.check');


        //cart
        Route::post('/cart', [CartController::class, 'store']);
        Route::get('/cart', [CartController::class, 'index']); // Retrieve cart items
        Route::delete('/cart/remove/{cartItemId}', [CartController::class, 'destroy']); // Remove an item from the cart
        Route::put('/cart/{cartItemId}/decrease', [CartController::class, 'decreaseQuantity']); // Decrease quantity of an item in the cart
        Route::put('/cart/{cartItemId}/increase', [CartController::class, 'increaseQuantity']); // Increase quantity of an item in the cart
        //clear cart
        Route::delete('/cart/clear', [CartController::class, 'clearCart']); // Clear the cart

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
