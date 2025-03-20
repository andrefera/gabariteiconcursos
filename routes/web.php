<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Store\CheckoutController;
use App\Http\Middleware\Jwt;
use App\Http\Middleware\SessionTokenMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/camiseta/camisa-jogador-flamengo', function () {
    return view('details.index');
});

Route::get('/carrinho', function () {
    return view('cart.index');
});

Route::get('/camisetas', function () {
    return view('list.index');
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

Route::prefix('checkout')->middleware(SessionTokenMiddleware::class)->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
});


