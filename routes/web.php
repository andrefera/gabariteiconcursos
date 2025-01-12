<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Jwt;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'loginAction'])->name('auth.login');
    Route::post('register', [AuthController::class, 'registerAction'])->name('auth.register');
    Route::post('logout', [AuthController::class, 'logout'])->middleware(Jwt::class);
    Route::post('change-password', [AuthController::class, 'changePassword'])->middleware(Jwt::class);
    Route::get('me', [AuthController::class, 'me']);
});

Route::prefix('admin')->group(function () {
    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::get('post', [ProductController::class, 'createOrUpdate'])->name('product.store');
    });
})->middleware(Admin::class);
