<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Models\WorkspaceUser;

class CreatedBoardChannel
{
    public function __construct() {}

    public function join(User $user, string $workspaceId): bool
    {
        return WorkspaceUser::query()
            ->where('user_id', $user->id)
            ->where('workspace_id', $workspaceId)
            ->exists();
    }
}
