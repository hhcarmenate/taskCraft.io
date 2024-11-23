<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceUser;
use Illuminate\Support\Facades\Log;

class WorkspaceChannel
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
