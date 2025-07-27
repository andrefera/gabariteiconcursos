<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Store\CartController;
use App\Http\Controllers\Store\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Store\ProductSearchController;
use App\Http\Middleware\CheckUserProfile;
use App\Http\Middleware\SessionTokenMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/', function () {
        return view('home');
    });

    // Autenticação (páginas)
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'loginWeb'])->name('login.submit');
    Route::post('register', [AuthController::class, 'registerWeb'])->name('register.submit');

    // Rotas públicas
    Route::get('/camiseta/camisa-jogador-flamengo', function () {
        return view('details.index');
    });

    Route::get('/camisetas', function () {
        return view('list.index');
    });

    Route::get('/etiqueta', function () {
        return view('orders.shipping_label');
    });

    // Carrinho com middleware
    Route::prefix('carrinho')->middleware(SessionTokenMiddleware::class)->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::get('/adicionar', [CartController::class, 'addItem'])->name('cart.add');
        Route::put('/item/{item}', [CartController::class, 'updateItem'])->name('cart.update');
        Route::delete('/item/{item}', [CartController::class, 'removeItem'])->name('cart.remove');
        Route::delete('/limpar', [CartController::class, 'clear'])->name('cart.clear');
    });

    // Rotas autenticadas
    Route::middleware('auth')->group(function () {
        Route::get('/minha-conta', function () {
            return view('orders.index');
        });

        Route::get('/meus-dados', function () {
            return view('orders.data');
        });

        Route::get('/meus-pedidos', function () {
            return view('orders.orders');
        });

        Route::post('logout', [AuthController::class, 'logoutWeb'])->name('logout');

        Route::get('profile/complete', [ProfileController::class, 'complete'])->name('profile.complete');
        Route::post('profile/complete', [ProfileController::class, 'completeStore'])->name('profile.complete.store');

        // Checkout
        Route::prefix('checkout')->middleware([CheckUserProfile::class, SessionTokenMiddleware::class])->group(function () {
            Route::get('/endereco', [CheckoutController::class, 'index'])->name('checkout.index');
            Route::get('/calculate-shipping/{address}', [CheckoutController::class, 'calculateShipping'])->name('checkout.calculate-shipping');
            Route::delete('/address', [CheckoutController::class, 'deleteAddress'])->name('checkout.delete-address');
            Route::post('/save-shipping', [CheckoutController::class, 'saveShipping'])->name('checkout.save-shipping');
            Route::get('/pagamento', [CheckoutController::class, 'payment'])->name('checkout.payment');
            Route::post('pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
            Route::get('/pagamento-confirmado/{id}', [CheckoutController::class, 'confirmacaoPagamento'])->name('checkout.confirmacao');
        });

        // API protegida
        Route::prefix('api')->group(function () {
            Route::prefix('addresses')->group(function () {
                Route::get('/{address}', [App\Http\Controllers\Api\AddressController::class, 'show']);
                Route::post('/', [App\Http\Controllers\Api\AddressController::class, 'store']);
                Route::put('/{address}', [App\Http\Controllers\Api\AddressController::class, 'update']);
                Route::delete('/{address}', [App\Http\Controllers\Api\AddressController::class, 'destroy']);
            });
        });
    });

    // Auth extra
    Route::prefix('auth')->group(function () {
        Route::post('change-password', [AuthController::class, 'changePassword'])->middleware('auth');
        Route::get('me', [AuthController::class, 'me']);
        Route::get('google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
        Route::get('google/callback', [AuthController::class, 'handleGoogleCallback']);
        Route::get('facebook', [AuthController::class, 'redirectToFacebook'])->name('auth.facebook');
        Route::get('facebook/callback', [AuthController::class, 'handleFacebookCallback']);
    });

    // Busca
    Route::get('/search/products', [ProductSearchController::class, 'search']);
});
