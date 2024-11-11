<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Traits\FailResponseTrait;
use App\Models\BoardList;
use App\Services\TaskService;
use Exception;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    use FailResponseTrait;
    private TaskService $taskService;

    /**
     * TaskController constructor.
     * @param TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Creates a new task based on the provided request and board list.
     *
     * @param StoreTaskRequest $request The request containing task details.
     * @param BoardList $boardList The board list where the task will be created.
     *
     * @return TaskResource|JsonResponse Returns the created task as a resource or a JSON response in case of failure.
     */
    public function createTask(StoreTaskRequest $request, BoardList $boardList): TaskResource|JsonResponse
    {
        try {
            return TaskResource::make($this->taskService->createListTask($request, $boardList));
        } catch (Exception $e) {
            return $this->genericFailResponse($e);
        }
    }
}
