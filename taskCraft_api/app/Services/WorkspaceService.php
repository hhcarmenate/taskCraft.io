<?php

namespace App\Services;

use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceUserRole;
use Exception;
use Illuminate\Http\Request;

class WorkspaceService
{
    public function getMyWorkSpaces(User $user)
    {
        return $user->workspaces;
    }


    /**
     * Create a new workspace in the TaskCraft.io application.
     *
     * This method creates a new workspace using the provided request data.
     * It first creates the workspace in the database by inserting the name, type, and description.
     * Then, it fetches the role of 'Owner' from the WorkspaceUserRole model.
     * If the creation process fails or the role is not found, an exception is thrown.
     * Finally, it attaches the user to the newly created workspace with the 'Owner' role.
     *
     * @param Request $request The HTTP request containing workspace data
     * @return Workspace The newly created workspace
     * @throws Exception
     */
    public function createWorkspace(Request $request): Workspace
    {
        $workspace = Workspace::query()->create([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'description' => $request->input('description')
        ]);

        $role = WorkspaceUserRole::query()->where('role_name', 'Owner')->first();

        if (!$workspace || !$role) {
            throw new Exception('Workspace creation fail, please try again later!');
        }

        $request->user()->workspace()->attach($request->user()->id, ['workspace_user_role_id_id' => $role->id]);

        return $workspace;
    }
}
