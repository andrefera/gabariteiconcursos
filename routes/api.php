<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\Jwt;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(["status" => "ok"]);
});

Route::post('admin/auth/login', [AuthController::class, 'loginAction'])->name('auth.login');

Route::prefix('admin')->middleware(Jwt::class)->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
    });

    Route::prefix('product')->group(function () {
        Route::get('/get-all', [ProductController::class, 'index'])->name('product.index');
        Route::get('/get/{product}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/store', [ProductController::class, 'createOrUpdate'])->name('product.store');
        Route::post('/delete/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    });

    Route::prefix('team')->group(function () {
        Route::get('/get-all', [TeamController::class, 'index'])->name('team.index');
        Route::get('/get/{team}', [TeamController::class, 'edit'])->name('team.edit');
        Route::post('/store', [TeamController::class, 'createOrUpdate'])->name('team.store');
        Route::post('/delete/{team}', [TeamController::class, 'destroy'])->name('team.destroy');
        Route::get('/filter', [TeamController::class, 'filter'])->name('team.filter');
    });
});

