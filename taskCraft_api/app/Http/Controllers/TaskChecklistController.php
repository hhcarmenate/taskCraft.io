<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskChecklistRequest;
use App\Http\Requests\UpdateTaskChecklistRequest;
use App\Http\Resources\TaskChecklistResource;
use App\Http\Traits\FailResponseTrait;
use App\Models\Task;
use App\Models\TaskChecklist;
use App\Services\TaskChecklistService;
use Exception;
use Illuminate\Http\JsonResponse;

class TaskChecklistController extends Controller
{
    use FailResponseTrait;
    private TaskChecklistService $taskChecklistService;

    /**
     * TaskChecklistController constructor.
     * @param TaskChecklistService $taskChecklistService
     */
    public function __construct(TaskChecklistService $taskChecklistService)
    {
        $this->taskChecklistService = $taskChecklistService;
    }


    /**
     * Create Task Checklist.
     * @param StoreTaskChecklistRequest $request
     * @param Task $task
     * @return TaskChecklistResource|JsonResponse
     * @throws Exception
     */
    public function createTaskChecklist(StoreTaskChecklistRequest $request, Task $task): TaskChecklistResource|JsonResponse
    {
        return TaskChecklistResource::make($this->taskChecklistService->createChecklist($request, $task));
    }

    /**
     * Update Task Checklist.
     * @param UpdateTaskChecklistRequest $request
     * @param TaskChecklist $taskChecklist
     * @return TaskChecklistResource|JsonResponse
     */
    public function updateTaskChecklist(UpdateTaskChecklistRequest $request, TaskChecklist $taskChecklist): TaskChecklistResource|JsonResponse
    {
        return TaskChecklistResource::make($this->taskChecklistService->updateTasksChecklists($request, $taskChecklist));
    }

    /**
     * Remove Task Checklist.
     *
     * @param TaskChecklist $taskChecklist The task checklist to be removed
     * @return TaskChecklistResource The resource representing the removed task checklist
     */
    public function removeTaskChecklist(TaskChecklist $taskChecklist): TaskChecklistResource
    {
        return TaskChecklistResource::make($this->taskChecklistService->removeTaskChecklist($taskChecklist));
    }
}
