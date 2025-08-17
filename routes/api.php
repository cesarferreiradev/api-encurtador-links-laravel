<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/{link}', [RedirectController::class, 'redirect'])->name('redirect-link');

Route::apiResource('links', LinkController::class);

Route::group(['prefix' => 'auth'], function () {
    require __DIR__.'/auth.php';
});
