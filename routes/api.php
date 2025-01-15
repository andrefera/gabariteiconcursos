<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(["status" => "ok"]);
});

Route::prefix('admin')->group(function () {
    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::get('post', [ProductController::class, 'createOrUpdate'])->name('product.store');
    });
})->middleware(Admin::class);

