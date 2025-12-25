<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\PushSubscriptionController;
use App\Http\Controllers\Api\SocialAuthController;



Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{id}', [NewsController::class, 'show']);
// Публичные маршруты
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{id}', [ServiceController::class, 'show']);

// Социальная авторизация (GitHub, Google, VK)
Route::get('/auth/social/{provider}/redirect', [SocialAuthController::class, 'redirect']);
Route::get('/auth/social/{provider}/callback', [SocialAuthController::class, 'callback']);

Route::middleware('auth:sanctum')->group(function () {
    // ...

    Route::post('/push-subscriptions', [PushSubscriptionController::class, 'store']);
    Route::delete('/push-subscriptions', [PushSubscriptionController::class, 'destroy']);
});


// Маршруты, требующие авторизации через Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Текущий пользователь (под Swagger /api/auth/me)
    Route::get('/auth/me', function (Request $request) {
        return $request->user();
    });

    // Адреса пользователя
    Route::get('/addresses', [AddressController::class, 'index']);
    Route::post('/addresses', [AddressController::class, 'store']);
    // при желании потом добавишь PUT/DELETE

    // Заказы
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);
});
