<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskChecklist;
use App\Models\TaskChecklistItem;
use Exception;
use Illuminate\Http\Request;

class TaskChecklistItemService
{
    /**
     * Create Task List Item
     * @param Request $request
     * @param TaskChecklist $taskChecklist
     * @return Task
     * @throws Exception
     */
    public function createChecklistItem(Request $request, TaskChecklist $taskChecklist): Task
    {
        $taskChecklistItem = TaskChecklistItem::query()->create([
            'checklist_id' => $taskChecklist->id,
            'description' => $request->input('description'),
            'completed' => false,
        ]);

        if (!$taskChecklistItem) {
            throw new Exception('Task Checklist Item creation fail, please try again later!');
        }

        return $taskChecklistItem;
    }

    /**
     * Update Task checklist item.
     * @param Request $request
     * @param TaskChecklistItem $taskChecklistItem
     * @return TaskChecklistItem
     */
    public function updateTasksChecklistItem(Request $request, TaskChecklistItem $taskChecklistItem): TaskChecklistItem
    {
        $taskChecklistItem->{$request->input('attribute')} = $request->input('value');
        $taskChecklistItem->save();

        $taskChecklistItem->refresh();

        return $taskChecklistItem;
    }

    /**
     * Remove a task checklist item
     * @param TaskChecklistItem $taskChecklistItem The task checklist item to be removed
     * @return TaskChecklistItem The removed task checklist item
     */
    public function removeTaskChecklistItem(TaskChecklistItem $taskChecklistItem): TaskChecklistItem
    {
        $taskChecklistItem->delete();

        return $taskChecklistItem;
    }
}
