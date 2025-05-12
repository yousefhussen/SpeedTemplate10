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

use Modules\Product\Http\Controllers\CategoryController;
use Modules\Product\Http\Controllers\ItemController;

Route::prefix('product')->group(function() {
    Route::get('/', 'ProductController@index');
    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/colors', [ItemController::class, 'getColors']);
    Route::get('/sizes', [ItemController::class, 'getSizes']);

});
//route to get the images in the rescources/assets/images directory by name
Route::get('/items/{filename}', function ($filename) {
    $path = module_path('Product', 'Resources/assets/Images/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    return response()->file($path);
})->name('images');
