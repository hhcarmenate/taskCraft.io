<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkspaceRequest;
use App\Http\Requests\UpdateWorkspaceRequest;
use App\Http\Resources\WorkspaceResource;
use App\Http\Traits\FailResponseTrait;
use App\Models\User;
use App\Models\Workspace;
use App\Notifications\WorkspaceInvitationNotification;
use App\Services\WorkspaceService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Notification;

class WorkspaceController extends Controller
{
    use FailResponseTrait;

    private WorkspaceService $workspaceService;

    /**
     * Constructor for TaskCraft.io Laravel application.
     *
     * @param WorkspaceService $workspaceService The service to handle workspace related operations.
     */
    public function __construct(WorkspaceService $workspaceService)
    {
        $this->workspaceService = $workspaceService;
    }

    /**
     * Retrieves the list of workspaces for the current user and returns it as a JSON response.
     *
     * @param Request $request The current HTTP request instance.
     * @return JsonResponse|AnonymousResourceCollection A JSON response containing the list of workspaces if successful,
     * or an empty data array with an error message in case of an exception.
     */
    public function index(Request $request): JsonResponse|AnonymousResourceCollection
    {
        try {
            return WorkspaceResource::collection($this->workspaceService->getMyWorkSpaces($request->user()));
        } catch(Exception $e) {
            return $this->genericFailResponse($e);
        }
    }

    /**
     * Creates a new workspace using the given request data.
     *
     * @param Request $request The request containing data for creating the workspace.
     * @return WorkspaceResource|JsonResponse The created workspace resource if successful,
     *                                      or a JSON response with error message if an exception occurs.
     */
    public function store(StoreWorkspaceRequest $request): WorkspaceResource|JsonResponse
    {
        try {
            return WorkspaceResource::make($this->workspaceService->createWorkSpace($request));
        } catch(Exception $e) {
            return $this->genericFailResponse($e);
        }
    }

    /**
     * Updates an existing workspace using the given request data and workspace entity.
     *
     * @param UpdateWorkspaceRequest $request The request containing the data for updating the workspace.
     * @param Workspace $workspace The workspace entity to be updated.
     * @return WorkspaceResource|JsonResponse The updated workspace resource if successful,
     *                                      or a JSON response with an error message if an exception occurs.
     */
    public function update(UpdateWorkspaceRequest $request, Workspace $workspace): WorkspaceResource|JsonResponse
    {
        try {
            return WorkspaceResource::make($this->workspaceService->updateWorkspace($request, $workspace));
        } catch(Exception $e) {
            return $this->genericFailResponse($e);
        }
    }

    /**
     * Retrieves the details of a workspace.
     *
     * @param Workspace $workspace The workspace for which details are to be retrieved.
     * @return WorkspaceResource|JsonResponse The workspace resource containing details if successful,
     *                                       or a JSON response with error message if an exception occurs.
     */
    public function show(Workspace $workspace): WorkspaceResource|JsonResponse
    {
        try {
            return WorkspaceResource::make($workspace);
        } catch(Exception $e) {
            return $this->genericFailResponse($e);
        }
    }

    /**
     * Deletes a workspace.
     *
     * @return WorkspaceResource|JsonResponse The deleted workspace resource if successful,
     *                                      or a JSON response with error message if an exception occurs.
     */
    public function delete(Workspace $workspace): WorkspaceResource|JsonResponse
    {
        try {
            return WorkspaceResource::make($this->workspaceService->destroyWorkspace($workspace));
        } catch(Exception $e) {
            return $this->genericFailResponse($e);
        }
    }

    /**
     * Generates an invitation link for the specified workspace.
     *
     * @param Workspace $workspace The workspace for which the invitation link is to be generated.
     *
     * @return JsonResponse A JSON response containing the generated invitation link if successful,
     *                      or a JSON response with error message if an exception occurs.
     */
    public function invitationLink(Workspace $workspace): JsonResponse
    {
        try {
            return response()->json([
                'invitation' => $this->workspaceService->useInvitationLink($workspace)
            ]);
        } catch (Exception $e) {
            return $this->genericFailResponse($e);
        }
    }

    /**
     * Sends an invitation to the specified recipients for the given workspace.
     *
     * @param Request $request The request containing the invitation details.
     *                        Requires 'invitationList' as required array and 'invitationText' as nullable string.
     * @param Workspace $workspace The workspace for which the invitation is being sent.
     * @return JsonResponse A JSON response indicating the success status of sending the invitation.
     *                     Includes a message indicating if the workspace invitation was sent successfully.
     */
    public function sendInvitation(Request $request, Workspace $workspace): JsonResponse
    {
        try {
            $request->validate([
                'invitationList' => 'required|array',
                'invitationTex' => 'string|nullable'
            ]);

            $subject = "New Workspace Invitation";

            foreach ($request->input('invitationList') as $email) {
                Notification::route('mail', trim($email))
                    ->notify(new WorkspaceInvitationNotification(
                        $subject,
                        $request->input('invitationText'),
                        $request->user()->name,
                        $workspace->name,
                        $this->workspaceService->useInvitationLink($workspace)
                    ));
            }


            return response()->json(['message' => 'Workspace Invitation sent successfully']);
        } catch (Exception $e) {
            return $this->genericFailResponse($e);
        }
    }

    public function getInvitationInfo(User $user): AnonymousResourceCollection | JsonResponse
    {

    }

    /**
     * Retrieve invitation information for the specified user.
     *
     * @param User $user The user for whom to fetch the invitation information.
     *
     * @return AnonymousResourceCollection|JsonResponse Returns a collection of workspace resources representing the
     *                                         invitations for the specified user if successful,
     *                                         or a JSON response with error message if an exception occurs.
     */
    public function getWorkspaces(User $user): AnonymousResourceCollection | JsonResponse
    {
        try {
            return WorkspaceResource::collection($this->workspaceService->getMyWorkSpaces($user));
        } catch(Exception $e) {
            return $this->genericFailResponse($e);
        }
    }
}
