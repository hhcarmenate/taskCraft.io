<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;

Route::namespace('Api\V1')->prefix('v1/')->name('track-craft')->group(function() {
    Route::middleware('auth:sanctum')->group(function(){
       Route::post('user/createWorkspace', [WorkspaceController::class, 'store'])
           ->name('createWorkspace');
    });

    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});
