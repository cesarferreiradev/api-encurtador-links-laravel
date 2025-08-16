<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

Route::apiResource('links', LinkController::class);

Route::group(['prefix' => 'auth'], function () {
    require __DIR__.'/auth.php';
});
