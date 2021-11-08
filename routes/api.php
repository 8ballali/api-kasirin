<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\api\AboutsController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ContactController;
use App\Http\Controllers\api\ContactUsController;
use App\Http\Controllers\api\EditProfileController;
use App\Http\Controllers\api\FaqController;
use App\Http\Controllers\api\KaryawanController;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\PrivacyPolicyController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\ResetPasswordController;
use App\Http\Controllers\api\RoleController;
use App\Http\Controllers\api\Statistic;
use App\Http\Controllers\api\StatistikCategory;
use App\Http\Controllers\api\StatistikPendapatan;
use App\Http\Controllers\api\StoreController;
use App\Http\Controllers\api\SubscriberController;
use App\Http\Controllers\api\SubscriptionController;
use App\Http\Controllers\api\TransactionController;
use App\Http\Controllers\api\TransactionDetailController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\UserRoleController;
use App\Http\Controllers\api\UserStoreController;
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
Route::post('login/admin', [AdminController::class, 'login']);
Route::post('register/admin', [AdminController::class, 'register']);
Route::post('forgot-password', [ResetPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [ResetPasswordController::class, 'reset']);
Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');
Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('karyawan', [KaryawanController::class, 'index']);
    Route::delete('karyawan/delete/{user}', [KaryawanController::class, 'destroy']);
    Route::post('karyawan/add', [KaryawanController::class, 'create']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::post('update-password', [AuthController::class, 'updatePassword']);
    Route::get('users', [UserController::class, 'index']);
    Route::get('product', [ProductController::class, 'index']);
    Route::get('product/{id}', [ProductController::class, 'show']);
    Route::post('product/store', [ProductController::class, 'store']);
    Route::post('product/edit/{product}', [ProductController::class, 'update']);
    Route::delete('product/delete/{product}', [ProductController::class, 'delete']);
    Route::get('abouts', [AboutsController::class, 'index']);
    Route::get('abouts/{id}', [AboutsController::class, 'show']);
    Route::post('abouts/store', [AboutsController::class, 'store']);
    Route::post('abouts/edit/{abouts}', [AboutsController::class, 'update']);
    Route::delete('abouts/delete/{abouts}', [AboutsController::class, 'delete']);
    Route::get('faq', [FaqController::class, 'index']);
    Route::get('faq/{id}', [FaqController::class, 'show']);
    Route::post('faq/store', [FaqController::class, 'store']);
    Route::post('faq/edit/{faq}', [FaqController::class, 'update']);
    Route::delete('faq/delete/{faq}', [FaqController::class, 'delete']);
    Route::get('category', [CategoryController::class, 'index']);
    Route::get('category/{id}', [CategoryController::class, 'show']);
    Route::post('category/store', [CategoryController::class, 'store']);
    Route::post('category/edit/{category}', [CategoryController::class, 'update']);
    Route::delete('category/delete/{category}', [CategoryController::class, 'delete']);
    Route::get('contact', [ContactController::class, 'index']);
    Route::get('contact/{id}', [ContactController::class, 'show']);
    Route::post('contact/store', [ContactController::class, 'store']);
    Route::post('contact/edit/{contact}', [ContactController::class, 'update']);
    Route::delete('contact/delete/{contact}', [ContactController::class, 'delete']);
    Route::get('role', [RoleController::class, 'index']);
    Route::get('role/{id}', [RoleController::class, 'show']);
    Route::post('role/edit/{role}', [RoleController::class, 'update']);
    Route::get('user-role', [UserRoleController::class, 'index']);
    Route::get('user-role/{id}', [UserRoleController::class, 'show']);
    Route::post('user-role/store', [UserRoleController::class, 'store']);
    Route::post('user-role/edit/{user_role}', [UserRoleController::class, 'update']);
    Route::delete('user-role/delete/{user_role}', [UserRoleController::class, 'delete']);
    Route::get('user-stores', [UserStoreController::class, 'index']);
    Route::get('user-stores/{id}', [UserStoreController::class, 'show']);
    Route::post('user-stores/edit/{user_stores}', [UserStoreController::class, 'update']);
    Route::delete('user-stores/delete/{user_stores}', [UserStoreController::class, 'delete']);
    Route::get('user/{id}', [EditProfileController::class, 'show']);
    Route::post('user/edit/{user}', [EditProfileController::class, 'update']);
    Route::get('admin/{id}', [AdminController::class, 'show']);
    Route::post('admin/edit/{admin}', [AdminController::class, 'update']);
    Route::get('subscription', [SubscriptionController::class, 'index']);
    Route::get('subscription/store', [SubscriptionController::class, 'store']);
    Route::get('subscriber', [SubscriberController::class, 'index']);
    Route::get('subscriber/{id}', [SubscriberController::class, 'show']);
    Route::post('subscriber/store', [SubscriberController::class, 'store']);
    Route::post('subscriber/edit/{subscriber}', [SubscriberController::class, 'update']);
    Route::resource('/stores', StoreController::class)->except(['create', 'edit']);
    Route::resource('/privacy', PrivacyPolicyController::class)->except(['create', 'edit']);
    Route::resource('/transaction', TransactionController::class)->except(['create', 'edit']);
    Route::resource('/detail-transaction', TransactionDetailController::class)->except(['create', 'edit']);
    Route::get('stats/product', [Statistic::class, 'index']);
    Route::get('stats/category', [StatistikCategory::class, 'index']);
    Route::get('stats/income', [StatistikPendapatan::class, 'index']);
    Route::get('/test', function () {
        return 'oek';
    });
});





