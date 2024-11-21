<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\BoardListController;
use App\Http\Controllers\TaskChecklistController;
use App\Http\Controllers\TaskChecklistItemController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskLogsController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Middleware\HandleExceptions;
use Illuminate\Support\Facades\Route;

Route::namespace('Api\V1')->prefix('v1/')->name('track-craft.')->group(function() {
    Route::middleware('auth:sanctum')->group(function(){

        // Workspace Routes
        Route::get('user/{user}/workspaces', [WorkspaceController::class, 'getWorkspaces' ])
            ->name('get-workspaces');
        Route::post('user/create-workspace', [WorkspaceController::class, 'store' ])
            ->name('create-workspace');
        Route::get('workspace/{workspace}/invitation', [WorkspaceController::class, 'invitationLink'])
            ->name('workspace-invitation');
        Route::get('workspace/check-invitation/{token}', [WorkspaceController::class, 'getInvitationInfo'])
             ->name('get-invitation-info');
        Route::post('workspace/{workspace}/send-invitation', [WorkspaceController::class, 'sendInvitation'])
             ->name('send-invitation');
        Route::post('workspace/{workspace}/update-logo', [WorkspaceController::class, 'updateLogo'])
            ->name('update-logo');
        Route::put('workspace/{workspace}/update-workspace', [WorkspaceController::class, 'update'])
            ->name('update-logo');
        Route::post('workspace/register-join', [WorkspaceController::class, 'registerAndJoin'])
            ->name('register-join');

        // Board Routes
        Route::post('board/create-board', [BoardController::class, 'store'])
            ->name('create-board');
        Route::post('board/{board}/toggle-starred', [BoardController::class, 'toggleStarred'])
            ->name('toggle-starred');
        Route::post('board/{board}/create-list', [BoardListController::class, 'createList'])
            ->name('create-list');
        Route::put('board/{board}/update-lists-positions', [BoardListController::class, 'updatePositions'])
            ->name('update-lists-positions');
        Route::post('board/recent-boards', [BoardController::class, 'saveRecentBoard'])
            ->name('save-recent-board');
        Route::get('board/recent-boards', [BoardController::class, 'getRecentBoards'])
            ->name('get-recent-boards');


        // List Routes
        Route::put('list/{boardList}/update-lists-title', [BoardListController::class, 'updateListTitle'])
            ->name('update-lists-title');
        Route::post('list/{boardList}/create-task', [TaskController::class, 'createTask'])
            ->name('create-task');
        Route::post('list/{boardList}/update-task-list', [TaskController::class, 'updateTasksLists'])
            ->name('update-tasks-lists');

        // Task Routes
        Route::patch('task/{task}/update-task-title', [TaskController::class, 'updateTaskTitle'])
            ->middleware(HandleExceptions::class)
            ->name('update-task-title');
        Route::patch('task/{task}/update-task-description', [TaskController::class, 'updateTaskDescription'])
            ->middleware(HandleExceptions::class)
            ->name('update-task-description');
        Route::patch('task/{task}/update-task-priority', [TaskController::class, 'updateTaskPriority'])
            ->middleware(HandleExceptions::class)
            ->name('update-task-priority');
        Route::patch('task/{task}/update-task-assign', [TaskController::class, 'updateTaskAssignTo'])
            ->middleware(HandleExceptions::class)
            ->name('update-task-assign');
        Route::patch('task/{task}/update-task-date', [TaskController::class, 'updateTaskDate'])
            ->middleware(HandleExceptions::class)
            ->name('update-task-start-date');

        //Task Comments
        Route::post('task/{task}/comment', [TaskCommentController::class, 'create'])
            ->middleware(HandleExceptions::class)
            ->name('create-task-comment');
        Route::patch('task/{task}/comment/{taskComment}', [TaskCommentController::class, 'update'])
            ->middleware(HandleExceptions::class)
            ->name('update-task-comment');
        Route::delete('task/{task}/comment/{taskComment}', [TaskCommentController::class, 'delete'])
            ->middleware(HandleExceptions::class)
            ->name('delete-task-comment');

        // Task Logs
        Route::get('task/{task}/logs', [TaskLogsController::class, 'getLogs'])
            ->middleware(HandleExceptions::class)
            ->name('get-task-logs');

        // Task Checklist Routes
        Route::post('task-checklist/{task}', [TaskChecklistController::class, 'createTaskChecklist'])
            ->middleware(HandleExceptions::class)
            ->name('create-task-checklist');
        Route::patch('task-checklist/{taskChecklist}', [TaskChecklistController::class, 'updateTaskChecklist'])
            ->middleware(HandleExceptions::class)
            ->name('update-task-checklist');
        Route::delete('task-checklist/{taskChecklist}', [TaskChecklistController::class, 'removeTaskChecklist'])
            ->middleware(HandleExceptions::class)
            ->name('remove-task-checklist');

        // Task Checklist Items Routes
        Route::post('task-checklist-item/{taskChecklist}', [TaskChecklistItemController::class, 'createTaskChecklistItem'])
            ->middleware(HandleExceptions::class)
            ->name('create-task-checklist-item');
        Route::patch('task-checklist-item/{taskChecklistItem}', [TaskChecklistItemController::class, 'updateTaskChecklistItem'])
            ->middleware(HandleExceptions::class)
            ->name('update-task-checklist-item');
        Route::delete('task-checklist-item/{taskChecklistItem}', [TaskChecklistItemController::class, 'removeTaskChecklistItem'])
            ->middleware(HandleExceptions::class)
            ->name('remove-task-checklist-item');




        // User Routes
        Route::get('user/{user}/profile', [UserProfileController::class, 'getUserProfile'])
            ->name('get-user-profile');
        Route::post('user/{user}/update-main-profile', [UserProfileController::class, 'updateMainProfile'])
            ->name('update-main-profile');
        Route::post('user/{user}/update-general-info-profile', [UserProfileController::class, 'updateGeneralProfile'])
            ->name('update-main-profile');

    });

    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});
