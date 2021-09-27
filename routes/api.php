<?php

use App\Http\Controllers\api\AboutsController;
use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\LoginController;
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
Route::post('login', [LoginController::class, 'login']);
Route::middleware(['api_key'])->group(function () {

    Route::resource('/abouts', AboutsController::class)->except(['create', 'edit']);
    Route::resource('/admin', AdminController::class)->except(['create', 'edit']);
    Route::get('/test', function () {
        return 'oek';
    });
});




// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
