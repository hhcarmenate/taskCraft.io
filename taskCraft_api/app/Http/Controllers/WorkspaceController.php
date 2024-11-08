<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendWorkspaceInvitationRequest;
use App\Http\Requests\StoreWorkspaceRequest;
use App\Http\Requests\UpdateWorkspaceRequest;
use App\Http\Requests\WorkspaceInvitationRequest;
use App\Http\Requests\WorkspaceRegisterJoinRequest;
use App\Http\Resources\WorkspaceResource;
use App\Http\Traits\FailResponseTrait;
use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceUserRole;
use App\Services\WorkspaceService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
     * Todo: Create a new cron that should run every 10 minutes and send the invitations
     * todo: if the user exist in the system send an invitation email and notification if not
     * todo: then send only the email
     *
     */
    public function sendInvitation(SendWorkspaceInvitationRequest $request, Workspace $workspace): JsonResponse
    {
        try {
            return response()->json($this->workspaceService->sendWorkspaceInvitation($request, $workspace));
        } catch (Exception $e) {
            return $this->genericFailResponse($e);
        }
    }

    /**
     * Get Invitation link info
     * @param WorkspaceInvitationRequest $request
     * @param Workspace $workspace
     * @return WorkspaceResource
     * @throws Exception
     */
    public function getInvitationInfo(WorkspaceInvitationRequest $request, String $token): WorkspaceResource
    {
        return WorkspaceResource::make($this->workspaceService->checkInvitation($token));
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

    /**
     * Updates the logo of the given workspace using the provided request data.
     *
     * @param Request $request The request containing the new logo data.
     * @param Workspace $workspace The workspace to update the logo for.
     * @return WorkspaceResource|JsonResponse The updated workspace resource if successful,
     *                                      or a JSON response with error message if an exception occurs.
     */
    public function updateLogo(Request $request, Workspace $workspace): WorkspaceResource|JsonResponse
    {
        try {
            return WorkspaceResource::make($this->workspaceService->updateLogo($request, $workspace));
        } catch(Exception $e) {
            return $this->genericFailResponse($e);
        }
    }

    /**
     * Register a new user and join them to a workspace using the provided request data.
     *
     * @param WorkspaceRegisterJoinRequest $request The request containing the user and workspace data.
     * @return JsonResponse A JSON response indicating success or failure of user registration and workspace join.
     */
    public function registerAndJoin(WorkspaceRegisterJoinRequest $request): JsonResponse
    {
        try {
            $user = User::query()->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);

            if (!$user) {
                throw ValidationException::withMessages([
                    'email' => ['Invalid user credentials']
                ]);
            }

            $workspace = Workspace::query()->find($request->input('workspace_id'));
            if (!$workspace) {
                throw new Exception('Invalid Workspace');
            }

            $member = WorkspaceUserRole::query()
                ->where('role_name', 'Member')
                ->firstOrFail();

            $workspace->users()->attach($user->id,['workspace_user_role_id' => $member->id]);

            return response()->json(['message' => 'User registered successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Oops! Something went wrong '. $e->getMessage()], 500);
        }
    }
}
