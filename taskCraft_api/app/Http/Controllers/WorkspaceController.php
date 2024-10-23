<?php

namespace App\Http\Controllers;

use App\Http\Resources\WorkspaceResource;
use App\Http\Traits\FailResponseTrait;
use App\Services\WorkspaceService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
    public function create(Request $request): WorkspaceResource|JsonResponse
    {
        try {
            return WorkspaceResource::make($this->workspaceService->createWorkSpace($request));
        } catch(Exception $e) {
            return $this->genericFailResponse($e);
        }
    }
}
