<?php

use App\Http\Controllers\Auth\SanctumApiController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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
Route::prefix('/token')->group(function () {
    Route::post('/create', [SanctumApiController::class, 'create'])->name('token.create');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::delete('/revoke/{tokenId}', [SanctumApiController::class, 'revoke'])->name('token.revoke');
        Route::delete('/revoke-all/', [SanctumApiController::class, 'revokeAll'])->name('token.revoke-all');
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/orders', [OrderController::class, 'showOrder'])->name('api.showOrder');
    Route::get('/order/show', [OrderController::class, 'showOrderByUser'])->name('api.showOrderByUser');
    Route::get('/products', [ProductController::class, 'showProduct'])->name('api.showProduct');
    Route::get('/product/{id}', [ProductController::class, 'showProductById'])->name('api.showProductById');
    Route::get('/users', [UserController::class, 'showUser'])->name('api.showUser');
    Route::get('/user/show', [UserController::class, 'showUserAuth'])->name('api.showUserAuth');
    Route::post('/comment', [CommentController::class, 'commentProductApi'])->name('api.comment');
    Route::post('/insertOrder', [OrderController::class, 'insertOrderApi'])->name('api.insertOrder');
});
