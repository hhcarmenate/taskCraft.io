<?php

namespace App\Services;

use App\Models\BoardList;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    /**
     * Create a new task within a given board list.
     *
     * @param Request $request The request object containing task information.
     * @param BoardList $boardList The board list in which the task will be created.
     *
     * @return Task The created board list with the new task added.
     * @throws Exception When the task creation fails.
     */
    public function createListTask(Request $request, BoardList $boardList): Task
    {
        $task = Task::query()->create([
            'list_id' => $boardList->id,
            'title' => $request->input('taskTitle'),
            'description' => null,
            'priority' => 'low',
            'created_by' => Auth::user()->id,
            'assigned_to' => null,
            'start_date' => null,
            'due_date' => null,
            'position' => $this->calculatePosition($boardList)
        ]);

        if (!$task) {
            throw new Exception('Board List creation fail, please try again later!');
        }

        return $task;
    }


    private function calculatePosition(BoardList $boardList): int
    {
        $lastTask = Task::query()
            ->where('list_id', $boardList->id)
            ->orderBy('position', 'Desc')
            ->first();

        if (!$lastTask) {
            return 1;
        }

        return $lastTask->position + 1;
    }

    /**
     * Update the positions of tasks within a given board list based on the provided request data.
     *
     * @param Request $request The request object containing task information, including task positions.
     * @param BoardList $boardList The board list whose tasks' positions will be updated.
     *
     * @return BoardList The board list after updating the tasks' positions.
     */
    public function updateTasksLists(Request $request, BoardList $boardList): BoardList
    {
        $tasks = $request->input('tasks');

        if (count($tasks)) {
            foreach ($tasks as $task) {
                $taskModel = Task::query()->find($task['id']);
                if ($taskModel) {
                    $taskModel->update([
                        'position' => $task['position'],
                        'list_id' => $boardList->id
                    ]);
                }
            }
        }

        $boardList->refresh();

        return $boardList;
    }

    /**
     * Updates the value of a specific field for a given task.
     *
     * @param string $field The name of the field to update.
     * @param mixed $value The new value to assign to the field.
     * @param Task $task The task object to update.
     *
     * @return Task The updated task object after the field value has been updated and saved.
     */
    public function updateTaskField(string $field, $value, Task $task): Task
    {
        $task->$field = $value;
        $task->save();
        $task->refresh();

        return $task;
    }

}
