<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Store\CartController;
use App\Http\Controllers\Store\CheckoutController;
use App\Http\Middleware\Jwt;
use App\Http\Middleware\SessionTokenMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/minha-conta', function () {
    return view('orders.index');
});

Route::get('/camiseta/camisa-jogador-flamengo', function () {
    return view('details.index');
});

// Cart Routes
Route::prefix('carrinho')->middleware(SessionTokenMiddleware::class)->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/adicionar', [CartController::class, 'addItem'])->name('cart.add');
    Route::put('/item/{item}', [CartController::class, 'updateItem'])->name('cart.update');
    Route::delete('/item/{item}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::delete('/limpar', [CartController::class, 'clear'])->name('cart.clear');
});

Route::get('/camisetas', function () {
    return view('list.index');
});

Route::get('/etiqueta', function () {
    return view('orders.shipping_label');
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'loginAction'])->name('auth.login');
    Route::post('register', [AuthController::class, 'registerAction'])->name('auth.register');
    Route::post('logout', [AuthController::class, 'logout'])->middleware(Jwt::class);
    Route::post('change-password', [AuthController::class, 'changePassword'])->middleware(Jwt::class);
    Route::get('me', [AuthController::class, 'me']);
    
    // Social Login Routes
    Route::get('google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('google/callback', [AuthController::class, 'handleGoogleCallback']);
    Route::get('facebook', [AuthController::class, 'redirectToFacebook'])->name('auth.facebook');
    Route::get('facebook/callback', [AuthController::class, 'handleFacebookCallback']);
});

Route::prefix('checkout')->middleware(SessionTokenMiddleware::class)->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
});

