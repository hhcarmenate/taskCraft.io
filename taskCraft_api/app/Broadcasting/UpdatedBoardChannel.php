<?php

namespace App\Broadcasting;

use App\Models\Board;
use App\Models\User;
use App\Models\WorkspaceUser;

class UpdatedBoardChannel
{
    public function join(User $user, string $boardId): bool
    {
        $board = Board::query()->find($boardId);

        return WorkspaceUser::query()
            ->where('user_id', $user->id)
            ->where('workspace_id', $board->workspace_id)
            ->exists();
    }
}
