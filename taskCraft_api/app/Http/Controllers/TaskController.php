<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Traits\FailResponseTrait;
use App\Models\BoardList;
use App\Services\TaskService;
use Exception;

class TaskController extends Controller
{
    use FailResponseTrait;
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function createTask(StoreTaskRequest $request, BoardList $boardList)
    {
        try {
            return TaskResource::make($this->taskService->createListTask($request, $boardList));
        } catch (Exception $e) {
            return $this->genericFailResponse($e);
        }
    }
}
