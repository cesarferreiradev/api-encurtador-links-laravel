<?php

use App\Http\Controllers\AuthenticatedController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthenticatedController::class, 'login'])
    ->name('login');

Route::post('/logout', [AuthenticatedController::class, 'logout']);
