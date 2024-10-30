<?php

namespace App\Services;

use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceUser;
use App\Models\WorkspaceUserRole;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class WorkspaceService
{
    /**
     * Getting all my workspaces
     * @param User $user
     * @return Collection
     */
    public function getMyWorkSpaces(User $user): Collection
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

        WorkspaceUser::query()->create([
            'workspace_id' => $workspace->id,
            'user_id' => $request->user()->id,
            'workspace_user_role_id' => $role->id
        ]);

        return $workspace;
    }

    /**
     * Updates the properties of a workspace based on the information provided in the request.
     *
     * @param mixed $request The request object containing the updated workspace information.
     * @param mixed $workspace The workspace object to be updated.
     *
     * @return mixed The updated workspace object.
     */
    public function updateWorkspace(Request $request, Workspace $workspace): mixed
    {
        if ($request->input('name')) {
            $workspace->name = $request->input('name');
        }

        if ($request->input('type')) {
            $workspace->type = $request->input('type');
        }

        if ($request->input('description')) {
            $workspace->description = $request->input('description');
        }

        $workspace->save();
        $workspace->refresh();

        return $workspace;
    }

    /**
     * Destroy the given workspace by deleting it.
     *
     * @param Workspace $workspace The workspace to be destroyed.
     * @return Workspace The destroyed workspace object.
     */
    public function destroyWorkspace(Workspace $workspace): Workspace
    {
        $workspace->delete();

        return $workspace;
    }

    /**
     * Generate and return an invitation link for the given workspace.
     *
     * @param Workspace $workspace The workspace for which the invitation link is being generated.
     *
     * @return string The complete invitation link URL containing the temporary signed route with workspace ID.
     */
    public function useInvitationLink(Workspace $workspace): String
    {
        $backendUrl = URL::temporarySignedRoute(
          'track-craft.get-invitation-info',
            now()->addDays(2),
            ['workspace' => $workspace->id]
        );

        return config('app.ui_app_url').'invitation-link?url=' . $backendUrl;
    }
}
