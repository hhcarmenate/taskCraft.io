<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskComment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskCommentService
{
    /**
     * @param Request $request
     * @param Task $task
     * @return TaskComment
     * @throws Exception
     */
    public function createTaskComment(Request $request, Task $task): TaskComment
    {
        $taskComment = TaskComment::query()->create([
            'task_id' => $task->id,
            'comment' => $request->input('comment'),
            'user_id' => Auth::user()->id
        ]);

        if (!$taskComment) {
            throw new Exception('Task Comment creation fail, please try again later!');
        }

        return $taskComment;
    }


    /**
     * @param Request $request
     * @param TaskComment $taskComment
     * @return TaskComment
     */
    public function updateTasksComment(Request $request, TaskComment $taskComment): TaskComment
    {
        $taskComment->comment = $request->input('comment');
        $taskComment->save();

        return $taskComment;
    }

    /**
     * Removes a comment associated with a task.
     *
     * @param TaskComment $taskComment The task comment to be removed.
     *
     * @return TaskComment The removed task comment.
     */
    public function removeTaskComment(TaskComment $taskComment): TaskComment
    {
        $taskComment->delete();

        return $taskComment;
    }

}
