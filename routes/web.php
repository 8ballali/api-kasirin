<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\SubscriberController;
use App\Http\Controllers\admin\SubscriptionController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

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


// Route::post('/post_login', [AuthController::class, 'postLogin'])->name('login');
Route::post('/login', [AuthController::class, 'index'])->name('login');

Route::get('/auth', [AuthController::class, 'index']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('/kasirin-toko/subscriptions', [SubscriptionController::class, 'index']);
    Route::get('/kasirin-toko/subscriptions/delete/{id}', [SubscriptionController::class, 'delete']);
    Route::get('/kasirin-toko/subscriptions/add', [SubscriptionController::class, 'add']);
    Route::post('/kasirin-toko/subscriptions/store', [SubscriptionController::class, 'store']);
    Route::get('/kasirin-toko/subscriptions/edit/{id}', [SubscriptionController::class, 'edit']);
    Route::put('/kasirin-toko/subscriptions/update/{id}', [SubscriptionController::class, 'update']);
    Route::get('/kasirin-toko/subscribers', [SubscriberController::class, 'index']);
    Route::get('/kasirin-toko/subscribers/edit/{id}', [SubscriberController::class, 'edit']);
    Route::put('/kasirin-toko/subscribers/update/{id}', [SubscriberController::class, 'update']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/', function () {
    return view('welcome');
});
