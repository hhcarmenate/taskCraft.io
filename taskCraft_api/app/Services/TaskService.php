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

}
