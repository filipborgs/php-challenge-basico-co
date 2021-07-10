<?php

use App\Http\Controllers\ProductController;
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

Route::get('/v1', function () {
    return 'PHP Challenge 20201117';
});

Route::group(
    [
        'prefix' => 'v1/products',
        'middleware' => ['api', 'apikey'],
    ],
    function () {
        Route::post('/', [ProductController::class, 'store']);
        Route::get('/', [ProductController::class, 'all']);
        Route::get('/paginate', [ProductController::class, 'paginate']);
        Route::get('/{id}', [ProductController::class, 'show']);
        Route::put('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'delete']);
    }
);
