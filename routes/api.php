<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/{short}', [RedirectController::class, 'redirect'])->name('redirect-link');

Route::group(['prefix' => 'admin'], function () {

    Route::middleware('auth:sanctum')
        ->apiResource('links', LinkController::class)
        ->only(['index', 'show', 'update', 'destroy']);

    Route::apiResource('links', LinkController::class)
        ->only(['store']);

    Route::apiResource('users', UserController::class)
        ->only('store');

    Route::get('users/me', [UserController::class, 'me']);

    Route::post('users/update', [UserController::class, 'update']);
});

Route::group(['prefix' => 'auth'], function () {
    require __DIR__.'/auth.php';
});
