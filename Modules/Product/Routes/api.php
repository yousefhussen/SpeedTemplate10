<?php

use Illuminate\Http\Request;
use Modules\Product\Http\Controllers\CategoryController;
use Modules\Product\Http\Controllers\ItemController;
use Modules\Product\Http\Controllers\ReviewController;

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

Route::prefix('product')->group(function() {

    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/colors', [ItemController::class, 'getColors']);
    Route::get('/sizes', [ItemController::class, 'getSizes']);
    //get item details by id
    Route::get('/items/{id}', [ItemController::class, 'show']);


    Route::group(['prefix' => 'reviews' ], function () {
        
        Route::group(['middleware' => 'auth:sanctum' ], function () {
            Route::post('/', [ReviewController::class, 'store']);
            // Route::put('/{review}', [ReviewController::class, 'update']);
            Route::delete('/{review}', [ReviewController::class, 'destroy']);
            Route::post('/{review}/like', [ReviewController::class, 'like'])->name('reviews.like');
            Route::post('/{review}/report', [ReviewController::class, 'report'])->name('reviews.report');
        });
        Route::get('/{item}', [ReviewController::class, 'itemReviews'])->name('reviews.itemReviews');
        Route::get('/{item}/stats', [ReviewController::class, 'getRatingStats'])->name('reviews.ratingStats');

    });


});

//get reviews images from the storage
Route::get('/reviews/images/{filename}', function ($filename) {
    $path = storage_path('app/public/reviews/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    return response()->file($path);
})->name('reviews.images');


//Images/Categories/
Route::get('/images/categories/{filename}', function ($filename) {
    $path = module_path('Product', 'Resources/assets/Images/Categories/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    return response()->file($path);

})->name('category.images');
//route to get the images in the rescources/assets/images directory by name
Route::get('/items/{filename}', function ($filename) {
    $path = module_path('Product', 'Resources/assets/Images/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    return response()->file($path);
})->name('images');
