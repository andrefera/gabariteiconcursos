<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\ApiAuthenticate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(["status" => "ok"]);
});

Route::prefix('admin')->group(function () {
    Route::post('auth/login', [AuthController::class, 'loginAction']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/me', [AuthController::class, 'me']);

    Route::middleware(ApiAuthenticate::class)->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index']);

        Route::prefix('product')->group(function () {
            Route::get('/get-all', [ProductController::class, 'index']);
            Route::get('/get/{product}', [ProductController::class, 'edit']);
            Route::post('/store', [ProductController::class, 'createOrUpdate']);
            Route::post('/delete/{product}', [ProductController::class, 'destroy']);
        });

        Route::prefix('team')->group(function () {
            Route::get('/get-all', [TeamController::class, 'index']);
            Route::get('/get/{team}', [TeamController::class, 'edit']);
            Route::post('/store', [TeamController::class, 'createOrUpdate']);
            Route::post('/delete/{team}', [TeamController::class, 'destroy']);
            Route::get('/filter', [TeamController::class, 'filter']);
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
            Route::post('/update-status', [OrderController::class, 'updateStatus'])->name('order.update.status');
            Route::post('/update-only-status', [OrderController::class, 'updateOnlyStatus'])->name('order.update.only.status');
        });
    });
});

Route::prefix('mercadopago')->group(function () {
    Route::post('/webhook', [OrderController::class, 'webhookMercadoPago']);
});
