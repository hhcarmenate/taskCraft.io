<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskCommentRequest;
use App\Http\Requests\UpdateTaskCommentRequest;
use App\Http\Resources\TaskCommentResource;
use App\Http\Traits\FailResponseTrait;
use App\Models\Task;
use App\Models\TaskComment;
use App\Services\TaskCommentService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskCommentController extends Controller
{
    use FailResponseTrait;
    private TaskCommentService $taskCommentService;

    /**
     * TaskController constructor.
     * @param TaskCommentService $taskCommentService
     */
    public function __construct(TaskCommentService $taskCommentService)
    {
        $this->taskCommentService = $taskCommentService;
    }

    /**
     * @param Task $task
     * @return AnonymousResourceCollection
     */
    public function getAllComments(Task $task): AnonymousResourceCollection
    {
        return TaskCommentResource::collection($task->taskComments);
    }


    /**
     * Creates a new task comment.
     *
     * @param StoreTaskCommentRequest $request The HTTP request object containing the request data.
     * @param Task $task The task for which the comment is being created.
     *
     * @return TaskCommentResource A resource representation of the newly created task comment.
     * @throws \Exception
     */
    public function create(StoreTaskCommentRequest $request, Task $task): TaskCommentResource
    {
        return TaskCommentResource::make($this->taskCommentService->createTaskComment($request, $task));
    }

    /**
     * Update a task comment using the provided request data and task comment instance.
     *
     * @param UpdateTaskCommentRequest $request The request data for updating the task comment
     * @*/
    public function update(UpdateTaskCommentRequest $request, TaskComment $taskComment): TaskCommentResource
    {
        return TaskCommentResource::make($this->taskCommentService->updateTasksComment($request, $taskComment));
    }

    /**
     * Deletes a TaskComment from the system.
     *
     * @param TaskComment $taskComment The TaskComment to be deleted.
     *
     * @return TaskCommentResource A TaskCommentResource representing the deleted TaskComment.
     */
    public function delete(TaskComment $taskComment): TaskCommentResource
    {
        return TaskCommentResource::make($this->taskCommentService->removeTaskComment($taskComment));
    }
}
