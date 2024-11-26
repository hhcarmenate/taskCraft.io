<?php

use App\Broadcasting\CreatedBoardChannel;
use App\Broadcasting\UpdatedBoardChannel;
use App\Broadcasting\WorkspaceChannel;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('workspace.{workspaceId}', WorkspaceChannel::class, ['guards' => ['web', 'admin']]);
Broadcast::channel('created_board.{workspaceId}', CreatedBoardChannel::class, ['guards' => ['web', 'admin']]);
Broadcast::channel('updated_board.{boardId}', UpdatedBoardChannel::class, ['guards' => ['web', 'admin']]);



Broadcast::channel('test-channel', function($user){
    return true;
});
