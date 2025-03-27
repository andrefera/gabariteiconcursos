<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
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
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

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

    Route::prefix('category')->group(function () {
        Route::get('/get-all', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/get/{category}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/store', [CategoryController::class, 'createOrUpdate'])->name('category.store');
        Route::post('/delete/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
        Route::get('/filter', [CategoryController::class, 'filter'])->name('category.filter');
    });

    Route::prefix('order')->group(function () {
        Route::get('/get-all', [OrderController::class, 'index'])->name('order.index');
        Route::get('/get/{order}', [OrderController::class, 'edit'])->name('order.edit');
        Route::post('/store', [OrderController::class, 'createOrUpdate'])->name('order.store');
        Route::post('/delete/{order}', [OrderController::class, 'destroy'])->name('order.destroy');
        Route::get('/filter', [OrderController::class, 'filter'])->name('order.filter');
        Route::get('/shipping-labels', [OrderController::class, 'downloadShippingLabels'])->name('order.shipping.labels');
    });
});

