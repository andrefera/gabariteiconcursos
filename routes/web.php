<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Store\CartController;
use App\Http\Controllers\Store\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Store\HomeController;
use App\Http\Controllers\Store\ProductController;
use App\Http\Controllers\Store\ProductSearchController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\TermsController;
use App\Http\Middleware\CheckUserProfile;
use App\Http\Middleware\SessionTokenMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Autenticação (páginas)
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'loginWeb'])->name('login.submit');
    Route::post('register', [AuthController::class, 'registerWeb'])->name('register.submit');


    Route::get('camisas', [ProductController::class, 'index'])->name('products.index');
    Route::get('/camisa/{url?}', [ProductController::class, 'detail'])->name('products.detail');
    Route::get('/time/{teamUrl?}', [ProductController::class, 'teamProducts'])->name('products.team');


    // Carrinho com middleware
    Route::prefix('cart')->middleware(SessionTokenMiddleware::class)->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add', [CartController::class, 'addItem'])->name('cart.add');
        Route::put('/item/{item}', [CartController::class, 'updateItem'])->name('cart.update');
        Route::delete('/item/{item}', [CartController::class, 'removeItem'])->name('cart.remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
    });

    // Rotas autenticadas
    Route::middleware('auth')->group(function () {
        Route::get('/minha-conta', [ProfileController::class, 'index'])->name('profile.index');

        Route::get('/meus-dados', function () {
            return view('orders.data');
        })->name('orders.data');

        Route::get('/meus-pedidos', function () {
            return view('orders.orders');
        })->name('orders.index');

        Route::post('logout', [AuthController::class, 'logoutWeb'])->name('logout');

        Route::get('profile/complete', [ProfileController::class, 'complete'])->name('profile.complete');
        Route::post('profile/complete', [ProfileController::class, 'completeStore'])->name('profile.complete.store');

        // Checkout
        Route::prefix('checkout')->middleware([CheckUserProfile::class, SessionTokenMiddleware::class])->group(function () {
            Route::get('/address', [CheckoutController::class, 'index'])->name('checkout.index');
            Route::get('/calculate-shipping/{address}', [CheckoutController::class, 'calculateShipping'])->name('checkout.calculate-shipping');
            Route::delete('/address', [CheckoutController::class, 'deleteAddress'])->name('checkout.delete-address');
            Route::post('/save-shipping', [CheckoutController::class, 'saveShipping'])->name('checkout.save-shipping');
            Route::get('/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
            Route::post('pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
            Route::get('/payment-confirmed/{id}', [CheckoutController::class, 'confirmacaoPagamento'])->name('checkout.confirmacao');
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

    // Política de Privacidade
    Route::get('/politica-privacidade', [PrivacyController::class, 'index'])->name('privacy.policy');

    // Termos de Uso
    Route::get('/termos-uso', [TermsController::class, 'index'])->name('terms.use');

    // Times
    Route::get('/teams', [App\Http\Controllers\HomeController::class, 'getTeams'])->name('teams.get');
});
