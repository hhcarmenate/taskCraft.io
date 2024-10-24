<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::namespace('Api\V1')->prefix('v1/')->name('track-craft')->group(function() {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});
