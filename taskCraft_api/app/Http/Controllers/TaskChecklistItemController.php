<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskChecklistRequest;
use App\Http\Requests\UpdateTaskChecklistRequest;
use App\Http\Resources\TaskChecklistItemResource;
use App\Http\Resources\TaskChecklistResource;
use App\Http\Traits\FailResponseTrait;
use App\Models\TaskChecklist;
use App\Models\TaskChecklistItem;
use App\Services\TaskChecklistItemService;
use Exception;
use Illuminate\Http\JsonResponse;

class TaskChecklistItemController extends Controller
{
    use FailResponseTrait;
    private TaskChecklistItemService $taskChecklistItemService;

    /**
     * TaskChecklistItemController Service.
     * @param TaskChecklistItemService $taskChecklistItemService
     */
    public function __construct(TaskChecklistItemService $taskChecklistItemService)
    {
        $this->taskChecklistItemService = $taskChecklistItemService;
    }


    /**
     * Create task check list item.
     * @param StoreTaskChecklistRequest $request
     * @param TaskChecklist $taskChecklist
     * @return TaskChecklistItemResource|JsonResponse
     * @throws Exception
     */
    public function createTaskChecklistItem(StoreTaskChecklistRequest $request, TaskChecklist $taskChecklist): TaskChecklistItemResource|JsonResponse
    {
        return TaskChecklistItemResource::make($this->taskChecklistItemService->createChecklistItem($request, $taskChecklist));
    }

    /**
     * Update task check list item.
     * @param UpdateTaskChecklistRequest $request
     * @param TaskChecklistItem $taskChecklistItem
     * @return TaskChecklistItemResource|JsonResponse
     */
    public function updateTaskChecklistItem(UpdateTaskChecklistRequest $request, TaskChecklistItem $taskChecklistItem): TaskChecklistItemResource|JsonResponse
    {
        return TaskChecklistItemResource::make($this->taskChecklistItemService->updateTasksChecklistItem($request, $taskChecklistItem));
    }

    /**
     * Remove a task checklist item.
     *
     * @param TaskChecklistItem $taskChecklistItem The task checklist item to be removed
     * @return TaskChecklistResource The updated task checklist resource after removing the item
     * @throws Exception
     */
    public function removeTaskChecklistItem(TaskChecklistItem $taskChecklistItem): TaskChecklistResource
    {
        return TaskChecklistResource::make($this->taskChecklistItemService->removeTaskChecklistItem($taskChecklistItem));
    }
}
