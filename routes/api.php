<?php

use App\Http\Controllers\api\AboutsController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\StoreController;
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
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware(['api_key', 'auth_token'])->group(function () {

    Route::resource('/abouts', AboutsController::class)->except(['create', 'edit']);
    Route::resource('/category', CategoryController::class)->except(['create', 'edit']);
    Route::resource('/product', ProductController::class)->except(['create', 'edit']);
    Route::resource('/stores', StoreController::class)->except(['create', 'edit']);
    Route::get('/test', function () {
        return 'oek';
    });
});




// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
