<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;

Route::namespace('Api\V1')->prefix('v1/')->name('track-craft.')->group(function() {
    Route::middleware('auth:sanctum')->group(function(){
       Route::post('user/createWorkspace', [WorkspaceController::class, 'store'])
           ->name('create-workspace');
       Route::get('workspace/{workspace}/invitation', [WorkspaceController::class, 'invitationLink'])
           ->name('workspace-invitation');
       Route::get('workspace/{workspace}/get-invitation-info', [WorkspaceController::class, 'getInvitationInfo'])
            ->name('get-invitation-info');
       Route::post('workspace/{workspace}/send-invitation', [WorkspaceController::class, 'sendInvitation'])
            ->name('send-invitation');

       Route::get('user/{user}/profile', [UserProfileController::class, 'getUserProfile'])
           ->name('get-user-profile');
    });

    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});
