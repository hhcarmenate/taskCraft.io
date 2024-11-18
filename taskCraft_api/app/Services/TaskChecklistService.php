<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskChecklist;
use Exception;
use Illuminate\Http\Request;

class TaskChecklistService
{
    /**
     * Create task checklist.
     * @param Request $request
     * @param Task $task
     * @return Task
     * @throws Exception
     */
    public function createChecklist(Request $request, Task $task): Task
    {
        $taskChecklist = TaskChecklist::query()->create([
            'task_id' => $task->id,
            'title' => $request->input('title'),
        ]);

        if (!$taskChecklist) {
            throw new Exception('Task Checklist creation fail, please try again later!');
        }

        return $taskChecklist;
    }

    /**
     * Update TaskChecklist
     * @param Request $request
     * @param TaskChecklist $taskChecklist
     * @return TaskChecklist
     */
    public function updateTasksChecklists(Request $request, TaskChecklist $taskChecklist): TaskChecklist
    {
        $taskChecklist->title = $request->input('title');
        $taskChecklist->save();

        $taskChecklist->refresh();

        return $taskChecklist;
    }

    /**
     * Remove task checklist.
     *
     * @param TaskChecklist $taskChecklist The task checklist to be removed.
     * @return TaskChecklist The removed task checklist.
     */
    public function removeTaskChecklist(TaskChecklist $taskChecklist): TaskChecklist
    {
        $taskChecklist->delete();

        return $taskChecklist;
    }
}
