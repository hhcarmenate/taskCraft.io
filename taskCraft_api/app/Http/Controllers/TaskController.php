<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskDescriptionRequest;
use App\Http\Requests\UpdateTasksListsRequest;
use App\Http\Requests\UpdateTaskTitleRequest;
use App\Http\Resources\BoardListResource;
use App\Http\Resources\TaskResource;
use App\Http\Traits\FailResponseTrait;
use App\Models\BoardList;
use App\Models\Task;
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
     * @throws Exception
     */
    public function createTask(StoreTaskRequest $request, BoardList $boardList): TaskResource|JsonResponse
    {
        return TaskResource::make($this->taskService->createListTask($request, $boardList));
    }

    /**
     * Updates the tasks lists based on the provided request and board list.
     *
     * @param UpdateTasksListsRequest $request The request containing the data required for updating tasks lists.
     * @param BoardList $boardList The board list to update tasks lists for.
     *
     * @return BoardListResource|JsonResponse Returns a BoardListResource if the tasks lists are updated successfully,
     * or a JsonResponse with error message if an exception occurs during the update process.
     */
    public function updateTasksLists(UpdateTasksListsRequest $request, BoardList $boardList): BoardListResource|JsonResponse
    {
        return BoardListResource::make($this->taskService->updateTasksLists($request, $boardList));
    }

    /**
     * Update the title of a task based on the provided UpdateTaskTitleRequest and Task objects.
     *
     * @param UpdateTaskTitleRequest $request The request object containing the new title for the task
     * @param Task $task The Task object to be updated with the new title
     * @return TaskResource|JsonResponse Returns a TaskResource if the task title is successfully updated, or a JsonResponse on failure
     */
    public function updateTaskTitle(UpdateTaskTitleRequest $request, Task $task): TaskResource|JsonResponse
    {
        $task->title = $request->input('newTitle');
        $task->save();
        $task->refresh();

        return TaskResource::make($task);
    }

    /**
     * Update the description of a task.
     *
     * @param UpdateTaskDescriptionRequest $request The request object containing the new task description.
     * @param Task $task The task object to be updated.
     * @return TaskResource|JsonResponse Returns a TaskResource if the task is updated successfully, or a JsonResponse with error message on failure.
     */
    public function updateTaskDescription(UpdateTaskDescriptionRequest $request, Task $task): TaskResource|JsonResponse
    {
        $task->description = $request->input('taskDescription');
        $task->save();
        $task->refresh();

        return TaskResource::make($task);
    }
}
